<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/api/auth/reset-password', function (Request $request) {
    return view('password.reset', ['token' => $request->token, 'email' => $request->email]);
})->name('password.reset');

if (config('app.debug')) {
    Route::get('/docs', function () {
        return view('swagger.index');
    });
}
