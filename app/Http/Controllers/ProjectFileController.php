<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\UploadAudiofileRequest;
use App\Services\ProjectService;

class ProjectFileController extends Controller
{
    public function uploadAudiofile(UploadAudiofileRequest $request, Project $project, ProjectService $projectService)
    {
        $projectService->saveAudiofile($request->audiofile, $project);

        return response($project->refresh());
    }
}
