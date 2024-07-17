<?php

namespace App\Http\Controllers;

use App\Filters\ProjectFilters;
use App\Models\Project;
use App\Models\User;
use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function store(CreateProjectRequest $request)
    {
        $userId = $request->query('user_id');
        if ($userId && !(User::find($userId) || Auth::id() == 'admin')) {
            return response(["message" => "Permission denied"], 422);
        } elseif (!$userId) {
            $userId = Auth::id();
        }

        $params = $request->all();
        $params['user_id'] = $userId;

        return response(Project::create($params));
    }

    public function show(Project $project)
    {
        $result = $project->toArray();
        $result['transcribes'] = $project->transcribes;

        return response($result);
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        return response($project->update($request->all()));
    }

    public function destroy(Project $project)
    {
        return response($project->delete());
    }

    public function getUserProjects(User $user, ProjectFilters $filters)
    {
        return response($filters->apply(Project::class)->where(['user_id' => $user->id])
            ->paginate($filters->itemsNum, ['*'], 'page', $filters->pageNum));
    }
}
