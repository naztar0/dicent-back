<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function logout()
    {
        Auth::logoutCurrentDevice();
        return User::find(Auth::id())->tokens()->delete();
    }
}
