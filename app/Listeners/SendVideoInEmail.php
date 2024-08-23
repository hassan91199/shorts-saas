<?php

namespace App\Listeners;

use App\Events\VideoRendered;
use App\Mail\VideoRenderedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendVideoInEmail
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

        if ($videoSeries->destination === 'email') {
            Mail::to($event->video->series->user->email)->send(new VideoRenderedMail($event->video));
        }
    }
}
