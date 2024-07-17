<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UploadImageRequest;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function store(RegisterUserRequest $request)
    {
        return response(User::create($request->all()));
    }

    public function update(UpdateUserRequest $request, User $user, UserService $userService)
    {
        if (!$userService->checkUpdateRequest($request)) {
            return response(['message' => 'Permission denied'], 403);
        }
        return $user->update($request->all());
    }

    public function destroy(User $user)
    {
        if ($user->id == Auth::id()) {
            return response(['message' => 'Deleting yourself is not allowed'], 422);
        }
        return $user->delete();
    }

    public function getMe()
    {
        return response(Auth::user());
    }

    public function uploadAvatar(UploadImageRequest $request, User $user, UserService $userService)
    {
        return response($user->update(['image' => $userService->saveImage($request->image)]));
    }
}
