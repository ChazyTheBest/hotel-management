<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserAccountInformation;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Fortify::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserAccountInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', fn (Request $request) =>
            Limit::perMinute(5)->by($request->session()->get('login.id'))
        );

        Fortify::loginView(fn () =>
            Inertia::render('Auth/Login', [
                'canResetPassword' => Route::has('password.request'),
                'status' => session('status')
            ])
        );

        Fortify::requestPasswordResetLinkView(fn () =>
            Inertia::render('Auth/ForgotPassword', [
                'status' => session('status')
            ])
        );

        Fortify::resetPasswordView(fn (Request $request) =>
            Inertia::render('Auth/ResetPassword', [
                'email' => $request->input('email'),
                'token' => $request->route('token')
            ])
        );

        Fortify::registerView(fn () =>
            Inertia::render('Auth/Register')
        );

        Fortify::verifyEmailView(fn () =>
            Inertia::render('Auth/VerifyEmail', [
                'status' => session('status')
            ])
        );

        Fortify::twoFactorChallengeView(fn () =>
            Inertia::render('Auth/TwoFactorChallenge')
        );

        Fortify::confirmPasswordView(fn () =>
            Inertia::render('Auth/ConfirmPassword')
        );
    }
}
