<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Illuminate\Http\Request;
use App\Http\Requests\LoginUserRequest;
use App\Actions\Fortify\{
    CreateNewUser,
    ResetUserPassword,
    UpdateUserPassword
};

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        if (!config('debug')) {
            RateLimiter::for('login', function (Request $request) {
                $email = (string) $request->email;
                return Limit::perMinute(5)->by($email . $request->ip());
            });
        }
        Fortify::loginThrough(function () {
            return [LoginUserRequest::class];
        });
    }
}
