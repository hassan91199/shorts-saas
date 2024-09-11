<?php

namespace App\Jobs;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessVideosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = User::all();
        $currentTime = time();

        foreach ($users as $user) {
            $isUserSubscribed = $user->subscribed('starter') || $user->subscribed('daily') || $user->subscribed('hardcore');

            if ($isUserSubscribed) {
                foreach ($user->series as $series) {
                    $currentVideo = $series->currentVideo();
                    $currentVideoCreationTimestamp = Carbon::parse($currentVideo->created_at)->timestamp;

                    $currentVideoTimeSpent = $currentTime - $currentVideoCreationTimestamp;
                    $currentVideoTimeSpentInHours = floor($currentVideoTimeSpent / 3600);

                    $videoCreationTimeGapByPlan = [
                        'starter' => 56,
                        'daily' => 24,
                        'hardcore' => 12,
                    ];

                    $userSubscribedPlan = $user->subscriptions()?->active()?->first()->type;
                    $timeGapForSubscribedPlan = $videoCreationTimeGapByPlan[$userSubscribedPlan];

                    if ($currentVideoTimeSpentInHours >= $timeGapForSubscribedPlan) {
                        // Dispatch a job to create video for that series
                        CreateVideoJob::dispatch($user, $series)->onQueue('create_video_queue');
                    }
                }
            }
        }
    }
}
