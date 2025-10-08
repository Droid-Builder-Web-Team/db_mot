<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Features;
use Laravel\Fortify\Actions\EnsureLoginIsNotThrottled;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Contracts\LoginViewResponse;
use Illuminate\Http\Response;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Standard Fortify Actions (Ensuring all features work)
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);


        // 2. Core Authentication Pipeline (Includes the 2FA enforcement)
        Fortify::authenticateThrough(function ($request) {
            return array_filter([
                // Rate Limiting
                config('fortify.limiters.login') ? null : EnsureLoginIsNotThrottled::class,
                
                // 🚨 2FA CHECK: This redirects to the challenge if a two-factor secret exists 🚨
                Features::enabled(Features::twoFactorAuthentication()) ? RedirectIfTwoFactorAuthenticatable::class : null,
                
                // Final Authentication Steps
                AttemptToAuthenticate::class,
                PrepareAuthenticatedSession::class,
            ]);
        });

        // 3. Rate Limiting Setup
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());
            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        // 4. View Customization (Tells Fortify where to find the views)
        Fortify::loginView(function () {
            return view('auth.login'); 
        });
        
        Fortify::twoFactorChallengeView(function () {
            return view('auth.two-factor-challenge');
        });
    }

    public function register(): void
    {
        // 🚨 ADD THIS BINDING 🚨
        $this->app->singleton(LoginViewResponse::class, function ($app) {
            return new class implements LoginViewResponse
            {
                public function toResponse($request)
                {
                    // No need for a Response type hint here, as we return
                    // the result of the global response() helper.
                    return response()->view('auth.login');
                }
            };
        });

        $this->app->bind(EnableTwoFactorAuthenticationContract::class, EnableTwoFactorAuthentication::class);
        $this->app->bind(ConfirmTwoFactorAuthenticationContract::class, ConfirmTwoFactorAuthentication::class);
        $this->app->bind(DisableTwoFactorAuthenticationContract::class, DisableTwoFactorAuthentication::class);

    }

}
