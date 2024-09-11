<?php declare(strict_types=1);

namespace App\Http\Middleware;

use App\Features\AccountFeatures;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Inertia\Middleware;
use Laravel\Fortify\Features;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'fortify' => [
                'canLogin' => Route::has('login'),
                'canRegister' => Features::enabled(Features::registration()),
                'canResetPassword' => Features::enabled(Features::resetPasswords()),
                'hasEmailVerification' => Features::enabled(Features::emailVerification()),
                'canUpdateAccountInformation' => Features::canUpdateProfileInformation(),
                'canUpdatePassword' => Features::enabled(Features::updatePasswords()),
                'canManageTwoFactorAuthentication' => Features::canManageTwoFactorAuthentication()
            ],
            'auth' => [
                'user' => $request->user() ? [
                    ...$request->user()->toArray(),
                    'two_factor_enabled' => Features::canManageTwoFactorAuthentication()
                        && ! is_null($request->user()?->two_factor_secret),
                    'hasAccountDeletionFeatures' => AccountFeatures::hasAccountDeletionFeatures(),
                    'managesAccountPhotos' => AccountFeatures::managesAccountPhotos()
                ] : null
            ],
            'flash' => $request->session()->get('flash', []),
            'errorBags' => fn () =>
                collect(Session::get('errors')?->getBags() ?: [])->mapWithKeys(fn ($bag, $key) =>
                    [$key => $bag->messages()]
                )->all(),
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url()
            ]
        ];
    }
}
