<?php

namespace App\Listeners;

use App\Events\ProjectEvent;
use App\Models\Project;
use App\Jobs\CheckProjectResult;
use App\Jobs\ProcessProjectResult;

class ProjectSaveResult
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ProjectEvent  $event
     * @return void
     */
    public function handle(ProjectEvent $event)
    {
        switch ($event->status) {
            case Project::STATUS_NONE:
            case Project::STATUS_QUEUED:
            case Project::STATUS_IN_PROGRESS:
                CheckProjectResult::dispatch($event->projectId);
                break;
            case Project::STATUS_COMPLETED:
                ProcessProjectResult::dispatch($event->projectId);
                break;
            default:
                break;
        }
    }
}
