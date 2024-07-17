<?php

namespace App\Http\Controllers;

use App\Filters\ProjectFilters;
use App\Models\Project;

class ProjectAdminController extends Controller
{
    public function index(ProjectFilters $filters)
    {
        return response($filters->apply(Project::class)
            ->paginate($filters->itemsNum, ['*'], 'page', $filters->pageNum));
    }
}
