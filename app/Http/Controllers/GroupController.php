<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use App\Http\Requests\CreateGroupRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function store(CreateGroupRequest $request)
    {
        $userId = $request->query('user_id');
        if ($userId && !(User::find($userId) || Auth::id() == 'admin')) {
            return response(["message" => "Permission denied"], 422);
        } elseif (!$userId) {
            $userId = Auth::id();
        }

        $params = $request->all();
        $params['user_id'] = $userId;

        return response(Group::create($params));
    }

    public function destroy(Group $group)
    {
        return response($group->delete());
    }

    public function getGroups(Request $request)
    {
        $userId = $request->query('user_id');
        if ($userId && !(User::find($userId) || Auth::id() == 'admin')) {
            return response(["message" => "Permission denied"], 422);
        } elseif (!$userId) {
            $userId = Auth::id();
        }
        return response(Group::where(['user_id' => $userId])->get());
    }
}
