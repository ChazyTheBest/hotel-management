<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController;
use Laravel\Fortify\Http\Controllers\ConfirmedTwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;
use Laravel\Fortify\Http\Controllers\EmailVerificationPromptController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController;
use Laravel\Fortify\Http\Controllers\TwoFactorSecretKeyController;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;
use Laravel\Fortify\RoutePath;

$enableViews = config('fortify.views', true);
$guard = config('fortify.guard', 'web');
$guestMiddleware = "guest:$guard";
$authMiddleware = config('fortify.auth_middleware', 'auth').":$guard";
$limiter = config('fortify.limiters.login');
$twoFactorLimiter = config('fortify.limiters.two-factor');
$verificationLimiter = config('fortify.limiters.verification', '6,1');

// Authentication...
if ($enableViews) {
    Route::get(
        RoutePath::for('login', '/login'),
        [AuthenticatedSessionController::class, 'create']
    )
        ->middleware([$guestMiddleware])
        ->name('login');
}

Route::post(
    RoutePath::for('login', '/login'),
    [AuthenticatedSessionController::class, 'store']
)
    ->middleware(array_filter([
        $guestMiddleware,
        $limiter ? 'throttle:'.$limiter : null,
    ]));

Route::post(
    RoutePath::for('logout', '/logout'),
    [AuthenticatedSessionController::class, 'destroy']
)
    ->middleware([$authMiddleware])
    ->name('logout');

// Password Reset...
if (Features::enabled(Features::resetPasswords())) {
    if ($enableViews) {
        Route::get(
            RoutePath::for('password.request', '/forgot-password'),
            [PasswordResetLinkController::class, 'create']
        )
            ->middleware([$guestMiddleware])
            ->name('password.request');

        Route::get(
            RoutePath::for('password.reset', '/reset-password/{token}'),
            [NewPasswordController::class, 'create']
        )
            ->middleware([$guestMiddleware])
            ->name('password.reset');
    }

    Route::post(
        RoutePath::for('password.email', '/forgot-password'),
        [PasswordResetLinkController::class, 'store']
    )
        ->middleware([$guestMiddleware])
        ->name('password.email');

    Route::post(
        RoutePath::for('password.update', '/reset-password'),
        [NewPasswordController::class, 'store']
    )
        ->middleware([$guestMiddleware])
        ->name('password.update');
}

// Registration...
if (Features::enabled(Features::registration())) {
    if ($enableViews) {
        Route::get(
            RoutePath::for('register', '/register'),
            [RegisteredUserController::class, 'create']
        )
            ->middleware([$guestMiddleware])
            ->name('register');
    }

    Route::post(
        RoutePath::for('register', '/register'),
        [RegisteredUserController::class, 'store']
    )
        ->middleware([$guestMiddleware]);
}

// Email Verification...
if (Features::enabled(Features::emailVerification())) {
    if ($enableViews) {
        Route::get(
            RoutePath::for('verification.notice', '/email/verify'),
            [EmailVerificationPromptController::class, '__invoke']
        )
            ->middleware([$authMiddleware])
            ->name('verification.notice');
    }

    Route::get(
        RoutePath::for('verification.verify', '/email/verify/{id}/{hash}'),
        [VerifyEmailController::class, '__invoke']
    )
        ->middleware([$authMiddleware, 'signed', 'throttle:'.$verificationLimiter])
        ->name('verification.verify');

    Route::post(
        RoutePath::for('verification.send', '/email/verification-notification'),
        [EmailVerificationNotificationController::class, 'store']
    )
        ->middleware([$authMiddleware, 'throttle:'.$verificationLimiter])
        ->name('verification.send');
}

// Account Information...
if (Features::enabled(Features::updateProfileInformation())) {
    Route::put(
        RoutePath::for('user-account-information.update', '/user/account-information'),
        [ProfileInformationController::class, 'update']
    )
        ->middleware([$authMiddleware])
        ->name('user-account-information.update');
}

// Passwords...
if (Features::enabled(Features::updatePasswords())) {
    Route::put(
        RoutePath::for('user-password.update', '/user/password'),
        [PasswordController::class, 'update']
    )
        ->middleware([$authMiddleware])
        ->name('user-password.update');
}

// Password Confirmation...
if ($enableViews) {
    Route::get(
        RoutePath::for('password.confirm', '/user/confirm-password'),
        [ConfirmablePasswordController::class, 'show']
    )
        ->middleware([$authMiddleware]);
}

Route::get(
    RoutePath::for('password.confirmation', '/user/confirmed-password-status'),
    [ConfirmedPasswordStatusController::class, 'show']
)
    ->middleware([$authMiddleware])
    ->name('password.confirmation');

Route::post(
    RoutePath::for('password.confirm', '/user/confirm-password'),
    [ConfirmablePasswordController::class, 'store']
)
    ->middleware([$authMiddleware])
    ->name('password.confirm');

// Two-Factor Authentication...
if (Features::enabled(Features::twoFactorAuthentication())) {
    if ($enableViews) {
        Route::get(
            RoutePath::for('two-factor.login', '/two-factor-challenge'),
            [TwoFactorAuthenticatedSessionController::class, 'create']
        )
            ->middleware([$guestMiddleware])
            ->name('two-factor.login');
    }

    Route::post(
        RoutePath::for('two-factor.login', '/two-factor-challenge'),
        [TwoFactorAuthenticatedSessionController::class, 'store']
    )
        ->middleware(array_filter([
            $guestMiddleware,
            $twoFactorLimiter ? 'throttle:'.$twoFactorLimiter : null,
        ]));

    $twoFactorMiddleware = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')
        ? 'password.confirm'
        : '';

    Route::middleware([$authMiddleware, $twoFactorMiddleware])->group(function () {
        Route::post(
            RoutePath::for('two-factor.enable', '/user/two-factor-authentication'),
            [TwoFactorAuthenticationController::class, 'store']
        )
            ->name('two-factor.enable');

        Route::post(
            RoutePath::for('two-factor.confirm', '/user/confirmed-two-factor-authentication'),
            [ConfirmedTwoFactorAuthenticationController::class, 'store']
        )
            ->name('two-factor.confirm');

        Route::delete(
            RoutePath::for('two-factor.disable', '/user/two-factor-authentication'),
            [TwoFactorAuthenticationController::class, 'destroy']
        )
            ->name('two-factor.disable');

        Route::get(
            RoutePath::for('two-factor.qr-code', '/user/two-factor-qr-code'),
            [TwoFactorQrCodeController::class, 'show']
        )
            ->name('two-factor.qr-code');

        Route::get(
            RoutePath::for('two-factor.secret-key', '/user/two-factor-secret-key'),
            [TwoFactorSecretKeyController::class, 'show']
        )
            ->name('two-factor.secret-key');

        Route::get(
            RoutePath::for('two-factor.recovery-codes', '/user/two-factor-recovery-codes'),
            [RecoveryCodeController::class, 'index']
        )
            ->name('two-factor.recovery-codes');

        Route::post(
            RoutePath::for('two-factor.recovery-codes', '/user/two-factor-recovery-codes'),
            [RecoveryCodeController::class, 'store']
        );
    });
}
