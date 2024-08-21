<?php

namespace App\Observers;

use App\Models\Video;

class VideoObserver
{
    /**
     * Handle the Video "creating" event.
     *
     * @param  \App\Models\Video  $video
     * @return void
     */
    public function creating(Video $video)
    {
        // Mark all existing videos of the same series 
        // as no longer current

        Video::where('series_id', $video->series_id)
            ->update(['is_current' => false]);
    }

    /**
     * Handle the Video "created" event.
     */
    public function created(Video $video): void
    {
        //
    }

    /**
     * Handle the Video "updated" event.
     */
    public function updated(Video $video): void
    {
        //
    }

    /**
     * Handle the Video "deleted" event.
     */
    public function deleted(Video $video): void
    {
        //
    }

    /**
     * Handle the Video "restored" event.
     */
    public function restored(Video $video): void
    {
        //
    }

    /**
     * Handle the Video "force deleted" event.
     */
    public function forceDeleted(Video $video): void
    {
        //
    }
}
