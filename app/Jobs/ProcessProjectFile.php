<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\ProjectService;
use App\Models\Project;

class ProcessProjectFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected int $projectId)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ProjectService $projectService)
    {
        if (!$project = Project::find($this->projectId)) {
            return;
        }
        $projectService->processAudiofile($project);

        CheckProjectResult::dispatch($this->projectId);
    }
}
