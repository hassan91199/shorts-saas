<?php

namespace App\Jobs;

use App\Http\Controllers\VidGenController;
use App\Models\ArtStyle;
use App\Models\Series;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CreateVideoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $series;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, Series $series)
    {
        $this->user = $user;
        $this->series = $series;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("Starting video creation for user {$this->user->id} and series {$this->series->id}");

        $artStyle = ArtStyle::find($this->series->art_style_id);
        // Send the video generation request to VidGen Module
        $url = config('vidgen.api_base_url') . '/vid-gen';
        $data = [
            'prompt' => Series::CATEGORY_PROMPTS[$this->series->category],
            'art_style' => $artStyle->name,
            'video_duration' => $this->series->video_duration,
            'apply_background_music' => $this->series->apply_background_music
        ];
        $vidGenResponse = Http::post($url, $data);
        $vidGenResponseData  = $vidGenResponse->json();

        $videoData = [
            'vid_gen_id' => $vidGenResponseData['video_id'] ?? null,
            'title' => $vidGenResponseData['title'] ?? '',
            'caption' => $vidGenResponseData['caption'] ?? '',
            'script' => $vidGenResponseData['script'] ?? '',
        ];

        // Create new video and associate it with series
        $video = $this->series->videos()->create($videoData);

        $vidGenId = $video->vid_gen_id;

        while (true) {
            $videoInfo = VidGenController::getVideoInfo($video->vid_gen_id);

            if (isset($videoInfo)) {
                $videoPath = $videoInfo['video_path'];

                // Check whether the video is ready
                if (isset($videoPath)) {
                    // Video is ready proceed with getting the video file
                    $videoFile = VidGenController::getVideofile($vidGenId);

                    if (isset($videoFile)) {
                        $extension = substr($videoPath, ((strrpos($videoPath, '.')) + 1));

                        $storedVideoPath = VidGenController::storeFile('videos', $extension, $videoFile);

                        // Update the video info in the db
                        $video->render_percentage = $videoInfo['percentage_completed'];
                        $video->video_url = $storedVideoPath;
                        $video->save();

                        break;
                    }
                } else {
                    sleep(10);
                    continue;
                }
            }
        }


        Log::info("Completed video creation for user {$this->user->id} and series {$this->series->id}");
    }
}
