<?php

namespace App\Providers;

use App\Actions\DeleteUser;
use App\Contracts\DeletesUsers;
use App\Http\Middleware\AuthenticateSession;
use Illuminate\Contracts\Session\Middleware\AuthenticatesSessions;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ForeignIdColumnDefinition;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Events\PasswordUpdatedViaController;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Macro to create an unsigned tiny integer auto-incrementing column
        Blueprint::macro('tinyId', fn ($column = 'id') =>
            $this->tinyIncrements($column)
        );

        // Macro to create an unsigned tiny integer column
        Blueprint::macro('foreignTinyId', fn ($column) =>
            $this->addColumnDefinition(new ForeignIdColumnDefinition($this, [
                'type' => 'tinyInteger',
                'name' => $column,
                'autoIncrement' => false,
                'unsigned' => true,
            ]))
        );

        // Bind the AuthenticatesSessions interface to the AuthenticateSession implementation in the service container.
        // This replaces the default auth factory with StatefulGuard
        $this->app->singleton(AuthenticatesSessions::class, AuthenticateSession::class);

        // Bind the DeletesUsers contract to the DeleteUser implementation in the service container.
        // This ensures that whenever DeletesUsers is requested, an instance of DeleteUser will be provided.
        $this->app->singleton(DeletesUsers::class, DeleteUser::class);

        RedirectResponse::macro('banner', fn ($message) =>
            /** @var \Illuminate\Http\RedirectResponse $this */
            $this->with('flash', [
                'bannerStyle' => 'success',
                'banner' => $message,
            ])
        );

        RedirectResponse::macro('warningBanner', fn ($message) =>
            /** @var \Illuminate\Http\RedirectResponse $this */
            $this->with('flash', [
                'bannerStyle' => 'warning',
                'banner' => $message,
            ])
        );

        RedirectResponse::macro('dangerBanner', fn ($message) =>
            /** @var \Illuminate\Http\RedirectResponse $this */
            $this->with('flash', [
                'bannerStyle' => 'danger',
                'banner' => $message,
            ])
        );

        // Update password hash to invalidate sanctum tokens
        Event::listen(function (PasswordUpdatedViaController $event) {
            if (request()->hasSession()) {
                request()->session()->put(['password_hash_sanctum' => Auth::user()->getAuthPassword()]);
            }
        });
    }
}
