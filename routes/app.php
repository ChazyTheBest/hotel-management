<?php

use App\Features\AccountFeatures;
use App\Http\Controllers\AccountPhotoController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CurrentUserController;
use App\Http\Controllers\OtherBrowserSessionsController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TermsOfServiceController;
use App\Http\Controllers\UserSettingsController;
use App\Models\BillingInfo;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

$guard = 'web';
$authMiddleware = "auth:$guard";

// Home route
Route::get('/', fn() =>
    Inertia::render('Home')
)->name('home');

// Legal texts
Route::get('/terms-of-service', [TermsOfServiceController::class, 'show'])->name('terms.show');
Route::get('/privacy-policy', [PrivacyPolicyController::class, 'show'])->name('policy.show');

// Room routes
Route::get('/rooms', [RoomController::class, 'index'])->name('room.index');
Route::get('/room/{room}', [RoomController::class, 'show'])->name('room.show');
Route::post('/room/{room}/check-availability', [RoomController::class, 'check'])->name('room.check');

Route::middleware([
    $authMiddleware
])->group(function() {
    $verifiedAuthMiddleware = 'verified';

    // User settings
    Route::get('/user/settings', [UserSettingsController::class, 'show'])->name('user-settings.show');

    if (AccountFeatures::managesAccountPhotos()) {
        Route::delete('/user/account-photo', [AccountPhotoController::class, 'destroy'])
            ->name('current-user-photo.destroy');
    }

    Route::delete('/user/other-browser-session/{session}', [OtherBrowserSessionsController::class, 'destroy'])
        ->name('other-browser-session.destroy');

    Route::delete('/user/other-browser-sessions', [OtherBrowserSessionsController::class, 'destroy'])
        ->name('other-browser-sessions.destroy');

    if (AccountFeatures::hasAccountDeletionFeatures()) {
        Route::delete('/user', [CurrentUserController::class, 'destroy'])
            ->name('current-user.destroy');
    }

    Route::middleware([
        $verifiedAuthMiddleware
    ])->group(function() {
        // Booking routes
        Route::get('/bookings', [BookingController::class, 'index'])
            ->can('viewAny', Booking::class)
            ->name('booking.index');

        Route::get('/booking/room/{room}', [BookingController::class, 'create'])
            ->can('create', [
                Booking::class,
                Payment::class,
                BillingInfo::class,
            ])
            ->name('booking.create');

        Route::post('/booking/room/{room}/store', [BookingController::class, 'store'])
            ->can('create', [
                Booking::class,
                Payment::class,
                BillingInfo::class,
            ])
            ->name('booking.store');

        Route::get('/booking/{booking}', [BookingController::class, 'show'])
            ->can('view', 'booking')
            ->name('booking.show');

        Route::get('/booking/{booking}/edit', [BookingController::class, 'edit'])
            ->can('update', 'booking')
            ->name('booking.edit');

        Route::put('/booking/{booking}', [BookingController::class, 'update'])
            ->can('update', 'booking')
            ->name('booking.update');

        Route::delete('/booking/{booking}', [BookingController::class, 'destroy'])
            ->can('delete', 'booking')
            ->name('booking.destroy');
    });
});
