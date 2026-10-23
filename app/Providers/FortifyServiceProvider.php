<?php

namespace App\Providers;

use App\Actions\Fortify\ResetUserPassword;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

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
        Fortify::loginView('auth.login');
        Fortify::requestPasswordResetLinkView('auth.forgot-password');
        Fortify::resetPasswordView('auth.reset-password');
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // 5 login attempts a minute for each email address and IP
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());
        });
    }
}
