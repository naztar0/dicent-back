<?php

namespace App\Http\Controllers;

use App\Filters\UserFilters;
use App\Models\User;
use App\Http\Controllers\UserController;

class UserAdminController extends UserController
{
    public function index(UserFilters $filters)
    {
        return response($filters->apply(User::class)
            ->paginate($filters->itemsNum, ['*'], 'page', $filters->pageNum));
    }

    public function show(User $user)
    {
        return $user;
    }
}
