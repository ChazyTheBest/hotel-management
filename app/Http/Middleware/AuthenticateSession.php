<?php declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Session\Middleware\AuthenticateSession as BaseAuthenticateSession;

class AuthenticateSession extends BaseAuthenticateSession
{
    /**
     * Get the guard instance that should be used by the middleware.
     *
     * @return \Illuminate\Contracts\Auth\Factory|\Illuminate\Contracts\Auth\Guard
     */
    protected function guard(): \Illuminate\Contracts\Auth\Factory|\Illuminate\Contracts\Auth\Guard
    {
        return app(StatefulGuard::class);
    }
}