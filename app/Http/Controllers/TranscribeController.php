<?php

namespace App\Http\Controllers;

use App\Models\Transcribe;
use App\Models\Project;
use App\Http\Requests\UpdateTranscribeRequest;

class TranscribeController extends Controller
{
    public function getTranscribes(Project $project)
    {
        return response($project->transcribes);
    }

    public function update(UpdateTranscribeRequest $request, Transcribe $transcribe)
    {
        return response($transcribe->update($request->all()));
    }

    public function destroy(Transcribe $transcribe)
    {
        return response($transcribe->delete());
    }
}
