<?php

namespace App\Services;

use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;

class UserService
{
    public function checkUpdateRequest(UpdateUserRequest $request)
    {
        return !(Auth::user()->role != Role::ADMIN && $request->exists('role'));
    }

    public function saveImage(UploadedFile $image)
    {
        $imageName = $image->hashName();
        $image->move(public_path('storage/images'), $imageName);
        return $imageName;
    }
}
