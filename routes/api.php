<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectAdminController;
use App\Http\Controllers\ProjectFileController;
use App\Http\Controllers\TranscribeController;
use App\Http\Controllers\GroupController;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/me', [UserController::class, 'getMe']);

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserAdminController::class, 'index'])->can('viewAny', User::class);
        Route::get('/{user}', [UserAdminController::class, 'show'])->can('view,user');
        Route::post('/', [UserController::class, 'store']);
        Route::patch('/{user}', [UserController::class, 'update'])->can('update,user');
        Route::delete('/{user}', [UserController::class, 'destroy'])->can('delete,user');
        Route::post('/{user}/avatar', [UserController::class, 'uploadAvatar'])->can('update,user');
        Route::get('/{user}/projects', [ProjectController::class, 'getUserProjects'])->can('view,user');
    });
    Route::group(['prefix' => 'projects'], function () {
        Route::get('/', [ProjectAdminController::class, 'index'])->can('viewAny', Project::class);
        Route::get('/{project}', [ProjectController::class, 'show'])->can('view,project');
        Route::post('/', [ProjectController::class, 'store']);
        Route::patch('/{project}', [ProjectController::class, 'update'])->can('update,project');
        Route::delete('/{project}', [ProjectController::class, 'destroy'])->can('delete,project');
        Route::get('/{project}/transcribes', [TranscribeController::class, 'getTranscribes'])->can('view,project');
        Route::post('/{project}/transcribe', [TranscribeController::class, 'create'])->can('update,project');
        Route::post('/{project}/audiofile', [ProjectFileController::class, 'uploadAudiofile'])->can('update,project');
    });
    Route::group(['prefix' => 'transcribes'], function () {
        Route::patch('/{transcribe}', [TranscribeController::class, 'update'])->can('update,transcribe');
        Route::delete('/{transcribe}', [TranscribeController::class, 'destroy'])->can('delete,transcribe');
    });
    Route::group(['prefix' => 'groups'], function () {
        Route::get('/', [GroupController::class, 'getGroups']);
        Route::post('/', [GroupController::class, 'store']);
        Route::delete('/{group}', [GroupController::class, 'destroy'])->can('delete,group');
    });
});
