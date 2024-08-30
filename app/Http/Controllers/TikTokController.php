<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TikTokController extends Controller
{
    public function redirectToTikTok(Request $request)
    {
        // Generating random string for code verifier
        $codeVerifier = bin2hex(random_bytes(32));
        // Save the code_verifier in a cookie or session for later use
        Cookie::queue('code_verifier', $codeVerifier, 10);

        // Generating the code_challenge from the code_verifier
        $codeChallenge = strtr(rtrim(base64_encode(hash('sha256', $codeVerifier, true)), '='), '+/', '-_');

        // Generate a random CSRF state token
        $csrfState = bin2hex(random_bytes(16));
        // Save the CSRF state token in a cookie with a 60-sec expiration
        Cookie::queue('csrfState', $csrfState, 1);

        // Buil the TikTok authorization URL
        $url = 'https://www.tiktok.com/v2/auth/authorize/';
        $params = [
            'client_key' => config('tiktok.client_key'),
            'scope' => implode(',', config('tiktok.scopes')),
            'response_type' => 'code',
            'redirect_uri' => config('tiktok.redirect_uri'),
            'state' => $csrfState,
            'code_challenge' => $codeChallenge,
            'code_challenge_method' => 'S256'
        ];

        // Append the parameters to the URL
        $authUrl = $url . '?' . http_build_query($params);

        return redirect($authUrl);
    }

    public function handleTikTokCallback(Request $request)
    {
        // Retrieve the authorization code from the query parameters
        $authorizationCode = $request->query('code');
        if (!$authorizationCode) {
            return redirect()->route('home')->with('error', 'Authorization code is missing');
        }

        $csrfState = $request->query('state');
        // Validate the state parameter to prevent CSRF attacks
        $savedCsrf = Cookie::get('csrfState');
        if ($csrfState != $savedCsrf) {
            return response('Invalid state parameter', 400);
        }

        // Prepare the parameters for the token request
        $params = [
            'client_key' => config('tiktok.client_key'),
            'client_secret' => config('tiktok.client_secret'),
            'code' => $authorizationCode,
            'grant_type' => 'authorization_code',
            'redirect_uri' => config('tiktok.redirect_uri')
        ];

        try {
            // Exchange authorization code for access token
            $response = Http::asForm()->post('https://open.tiktokapis.com/v2/oauth/token/', $params);

            if ($response->successful()) {
                $data = $response->json();

                $user = Auth::user();
                $user->tiktok_creds = json_encode($data);
                $user->save();

                return redirect()->route('series.index')->with('success', 'Tiktok account linked successfully.');
            } else {
                $error = $response->json('error', 'Failed to retrieve access token.');
                // Log the error response
                Log::error('TikTok token exchange failed', ['response' => $response->body(), 'error' => $error]);

                return redirect()->route('series.index')->with('error', $error);
            }
        } catch (\Exception $e) {
            // Log any exceptions
            Log::error('Exception during TikTok token exchange', ['exception' => $e->getMessage()]);

            return redirect()->route('series.index')->with('error', 'An error occurred while linking your TikTok account.');
        }
    }

    public function uploadVideoToTikTok($video)
    {
        $user = $video->user;
        $accessToken = $user->getTikTokAccessToken();

        $videoFilePath = public_path($video->video_url);
        $videoFileSize = filesize($videoFilePath);

        $chunkSize = 10000000;
        $totalChunkCount = (int) floor($videoFileSize / $chunkSize);

        if ($videoFileSize < 20000000) {
            // Video file size is less than 20MB so 
            // upload it as one chunk
            $chunkSize = $videoFileSize;
            $totalChunkCount = (int) floor($videoFileSize / $chunkSize);
        }

        $initializeVideoPublishResponse = Http::withHeaders([
            'Authorization' => "Bearer $accessToken",
            'Content-Type' => 'application/json; charset=UTF-8'
        ])->post('https://open.tiktokapis.com/v2/post/publish/video/init/', [
            'post_info' => [
                'title' => $video->title,
                'privacy_level' => 'SELF_ONLY',
                'disable_duet' => false,
                'disable_comment' => true,
                'disable_stitch' => false,
                'video_cover_timestamp_ms' => 1000
            ],
            'source_info' => [
                'source' => 'FILE_UPLOAD',
                'video_size' => $videoFileSize,
                'chunk_size' => $chunkSize,
                'total_chunk_count' => $totalChunkCount,
            ]
        ]);

        $initializeVideoPublishResponseData = $initializeVideoPublishResponse->json();

        if ($initializeVideoPublishResponse->successful()) {
            $publishId = $initializeVideoPublishResponseData['data']['publish_id'];
            $uploadUrl = $initializeVideoPublishResponseData['data']['upload_url'];

            // Save the tiktok publish id to the videos table
            $video->tiktok_publish_id = $publishId;
            $video->save();

            // Start the upload of the video to tiktok server
            $startByte = 0;
            $trailingBytes = $videoFileSize % $chunkSize;

            $fileHandle = fopen($videoFilePath, 'rb');

            for ($currentChunk = 1; $currentChunk <= $totalChunkCount; $currentChunk++) {
                // Determine the number of bytes to read for the current chunk
                $bytesToUpload = $chunkSize;
                if ($currentChunk === $totalChunkCount) {
                    // Adjust the size of the last chunk to include trailing bytes
                    $bytesToUpload += $trailingBytes;
                }

                // Read the specific chunk from the file
                fseek($fileHandle, $startByte);
                $fileContent = fread($fileHandle, $bytesToUpload);

                $endByte = $startByte + $bytesToUpload - 1;

                $uploadVideoChunkResponse = Http::withHeaders([
                    'Content-Range' => "bytes $startByte-$endByte/$videoFileSize",
                    'Content-Length' => $bytesToUpload,
                    'Content-Type' => 'video/mp4'
                ])->timeout(0)
                    ->withBody($fileContent, 'video/mp4')
                    ->put($uploadUrl);

                if (!$uploadVideoChunkResponse->successful()) {
                    fclose($fileHandle);
                    // Handle error if the upload fails
                    return 'Upload failed at chunk ' . $currentChunk;
                }

                // Update the start byte for the next chunk
                $startByte = $endByte + 1;
            }

            fclose($fileHandle);
        }
        return $publishId;
    }
}
