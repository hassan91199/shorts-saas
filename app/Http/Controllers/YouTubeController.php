<?php

namespace App\Http\Controllers;

use App\Models\LinkedAccount;
use Google_Client;
use Google_Service_Youtube;
use Google_Service_Youtube_Video;
use Google_Service_Youtube_VideoSnippet;
use Google_Service_Youtube_VideoStatus;
use Google_Service_Exception;
use Google_Exception;
use Google_Http_MediaFileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class YouTubeController extends Controller
{
    public function redirectToYoutube(Request $request)
    {
        // Initialize Google Client
        $client = $this->getGoogleClient();
        $authUrl = $client->createAuthUrl();

        // Redirect the user to Google's OAuth consent page
        return redirect()->away($authUrl);
    }

    public function handleYoutubeCallback(Request $request)
    {
        try {
            $client = $this->getGoogleClient();
            $authCode = $request->get('code');
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

            // Save the access token to the user's account
            $user = Auth::user();
            $user->youtube_token = json_encode($accessToken);
            $user->save();

            $client->setAccessToken($accessToken);

            // Get the user's channel info
            $youtubeService = new \Google_Service_Youtube($client);
            $channelsResponse = $youtubeService->channels->listChannels('id', ['mine' => true]);

            if (count($channelsResponse['items']) > 0) {
                $channelId = $channelsResponse['items'][0]['id'];

                LinkedAccount::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'provider_name' => 'youtube',
                        'provider_account_id' => $channelId,
                    ],
                    [
                        'access_token' => $accessToken['access_token'],
                        'refresh_token' => $accessToken['refresh_token'] ?? null,
                        'access_token_expires_at' => isset($accessToken['expires_in']) ? now()->addSeconds($accessToken['expires_in']) : null,
                    ]
                );
            } else {
                Log::error('No channels found for this user.');
            }

            return redirect()->route('series.index');
        } catch (\Exception $e) {
            Log::error('YouTube callback error: ' . $e->getMessage());
            return redirect()->route('series.index')->with('error', 'Failed to link YouTube account.');
        }
    }

    public function uploadVideoToYouTube($video)
    {
        Log::info('Inside uplaodVideoToYouTube() function');
        $client = $this->getGoogleClient();

        $user = $video->user;
        $accessToken = json_decode($user->youtube_token, true);
        $client->setAccessToken($accessToken);

        // Refresh the token if it has expired
        if ($client->isAccessTokenExpired()) {
            Log::info('Access token is expired');
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            $user->youtube_token = json_encode($client->getAccessToken());
            $user->save();
        }

        // Create youtube service object
        $youtube = new Google_Service_Youtube($client);

        // Create video object with necessary details
        $youtubeVideo = new Google_Service_Youtube_Video();
        $videoSnippet = new Google_Service_Youtube_VideoSnippet();
        $videoStatus = new Google_Service_Youtube_VideoStatus();

        // Set video snippet details
        $videoSnippet->setTitle($video->title);
        $videoSnippet->setDescription($video->caption);
        $videoSnippet->setCategoryId('22'); // Setting the category to 22 which is for People & Blogs

        // Setting video status to public
        $videoStatus->setPrivacyStatus('public');
        $videoStatus->setSelfDeclaredMadeForKids(false);

        // Adding the snippet and status to video
        $youtubeVideo->setSnippet($videoSnippet);
        $youtubeVideo->setStatus($videoStatus);

        // Upload video to youtube
        try {
            $chuckSizeByte = 1 * 1024 * 1024; // 1MB;

            $client->setDefer(true);

            $insertRequest = $youtube->videos->insert("status,snippet", $youtubeVideo);

            $filePath = public_path($video->video_url);

            // Creating MediaFileUpload obj for resumable uploads
            $media = new Google_Http_MediaFileUpload(
                $client,
                $insertRequest,
                'video/*',
                null,
                true,
                $chuckSizeByte
            );

            $media->setFileSize(filesize($filePath));

            // Reading file and uploading in chunks
            $status = false;
            $handle = fopen($filePath, "rb");
            while (!$status && !feof($handle)) {
                $chunck = fread($handle, $chuckSizeByte);
                $status = $media->nextChunk($chunck);
            }

            fclose($handle);

            $client->setDefer(false);

            $statusId = $status['id'] ?? null;

            if (isset($statusId)) {
                // Save the youtube video id for 
                // future requirements
                $video->youtube_video_id = $statusId;
                $video->saveQuietly(); // Avoiding dispatching the VideoRender event again

                return $statusId;
            } else {
                return null;
            }
        } catch (Google_Service_Exception $e) {
            return 'Caught google service exception: ' . htmlspecialchars($e->getMessage());
        } catch (Google_Exception $e) {
            return 'Caught Google exception: ' . htmlspecialchars($e->getMessage());
        }
    }

    private function getGoogleClient()
    {
        $client = new Google_Client();
        $client->setClientId(config('google.client_id'));
        $client->setClientSecret(config('google.client_secret'));
        $client->setRedirectUri(config('google.redirect_uri'));
        $client->addScope(config('google.scopes.youtube'));
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        return $client;
    }
}
