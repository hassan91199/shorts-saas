<?php

namespace App\Jobs;

use App\Models\Series;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
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

        sleep(5);

        Log::info("Completed video creation for user {$this->user->id} and series {$this->series->id}");
    }
}
