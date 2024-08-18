<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VidGenController extends Controller
{
    /**
     * Get the render info from the vidgen module
     *
     * @return Illuminate\Http\JsonResponse
     */
    public function getInfo(Request $request): JsonResponse
    {
        $vidGenId = $request->get('vid_gen_id');

        $video = Video::where('vid_gen_id', $vidGenId)->first();

        if (isset($video) && isset($video->video_url)) {
            // if video is present in the db and its url is 
            // set then return this video

            return response()->json([
                'render_percentage' => $video->render_percentage,
                'video_url' => $video->video_url,
            ]);
        } else {
            $videoInfoResponse = Http::post('http://localhost:31415/video-info', [
                'video_id' => $vidGenId
            ]);
            $videoInfoResponseData = $videoInfoResponse->json();

            if (isset($videoInfoResponseData['video']['video_path'])) {
                // the video is ready, we will save the path 
                // and progress in the db and return it to 
                // the front end

                $videoPath = $videoInfoResponseData['video']['video_path'];
                $extension = substr($videoPath, ((strrpos($videoPath, '.')) + 1));

                // getting the file of the video
                $getVideoResponse = Http::post('http://localhost:31415/get-video', [
                    'video_id' => $vidGenId
                ]);

                if ($getVideoResponse->successful()) {
                    $fileContent = $getVideoResponse->body();
                    $fileName = time() . '.' . $extension;
                    $filePath = 'videos/' . $fileName;

                    Storage::disk('public')->put($filePath, $fileContent);

                    // save the video progress and path
                    $video->render_percentage = $videoInfoResponseData['video']['percentage_completed'];
                    $video->video_url = 'storage/' . $filePath;
                    $video->save();

                    return response()->json([
                        'render_percentage' => $video->render_percentage,
                        'video_url' => $video->video_url,
                    ]);
                } else {
                    return response()->json([
                        'message' => 'An error occured while trying to get the video.',
                    ]);
                }
            } else {
                // the video is not ready yet we are updating 
                // the progress and sending the response to 
                // show the rendering progress

                $video->render_percentage = $videoInfoResponseData['video']['percentage_completed'];
                $video->video_url = $videoInfoResponseData['video']['video_path'];
                $video->save();

                return response()->json([
                    'render_percentage' => $video->render_percentage,
                    'video_url' => $video->video_url,
                ]);
            }
        }
    }
}
