<?php

namespace App\Listeners;

use App\Events\VideoRendered;
use App\Http\Controllers\TikTokController;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UploadVideoToTikTok
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(VideoRendered $event): void
    {
        $videoSeries = $event->video->series;
        $user = $event->video->user;
        $isUserSubscribed = $user->subscribed('starter') || $user->subscribed('daily') || $user->subscribed('hardcore');

        if ($videoSeries->destination === 'tiktok' && $isUserSubscribed) {
            Log::info('Catched video rendered event, uploading video to tiktok.');

            $tiktokController = new TikTokController();

            $tiktokController->uploadVideoToTikTok($event->video);
        }
    }
}
