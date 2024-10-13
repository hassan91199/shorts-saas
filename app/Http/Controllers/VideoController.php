<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;

class VideoController extends Controller
{
    /**
     * Update the video details and redirect back to the previous page.
     *
     * This method handles the request to update the details of a video.
     * After processing the request, it redirects the user back to the previous page.
     *
     * @param Request $request The incoming HTTP request containing the updated video data.
     * @param Video $video The video instance being updated.
     * @return RedirectResponse A redirect response to the previous page.
     */
    public function update(Request $request, Video $video): RedirectResponse
    {
        $newTitle = $request->get('title');
        $newCaption = $request->get('caption');
        $newScript = $request->get('script');

        $reRenderVideo = false;

        $vidgenPayload = [
            'script' => $video->script,
            'art_style' => $video->series->artStyle->name,
            'video_duration' => $video->series->video_duration,
            'apply_background_music' => $video->series->apply_background_music
        ];

        if ($video->title != $newTitle) {
            $video->title = $newTitle;
        }

        if ($video->caption != $newCaption) {
            $video->caption = $newCaption;
        }

        if ($video->script != $newScript) {
            $reRenderVideo = true;
            $video->script = $newScript;

            $vidgenPayload['script'] = $newScript;
        }

        if ($reRenderVideo === true) {
            $video->video_url = null;

            $url = config('vidgen.api_base_url') . '/vid-gen';
            $vidGenResponse = Http::post($url, $vidgenPayload);
            $vidGenResponseData = $vidGenResponse->json();

            $video->vid_gen_id = $vidGenResponseData['video_id'];
            $video->script = $vidGenResponseData['script'];
        }

        $video->save();

        return redirect()->back();
    }
}
