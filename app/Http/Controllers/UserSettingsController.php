<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Traits\HasDeviceDetector;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Laravel\Fortify\Features;

class UserSettingsController extends Controller
{
    use Concerns\ConfirmsTwoFactorAuthentication;
    use HasDeviceDetector;

    /**
     * Show the general account settings screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function show(Request $request): \Inertia\Response
    {
        $this->validateTwoFactorAuthenticationState($request);

        return Inertia::render('Account/Show', [
            'confirmsTwoFactorAuthentication' => Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm'),
            'sessions' => $this->sessions($request)->all()
        ]);
    }

    /**
     * Get the current sessions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Collection
     */
    public function sessions(Request $request): \Illuminate\Support\Collection
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }

        return collect(
            DB::connection(config('session.connection'))
                ->table(config('session.table', 'sessions'))
                ->where('user_id', $request->user()->getAuthIdentifier())
                ->where('last_activity', '>', Carbon::now()->subMinutes(config('session.lifetime'))->timestamp)
                ->whereNotIn('id', fn ($query) =>
                    $query->select('previous_id')
                          ->from(config('session.table', 'sessions'))
                          ->where('user_id', $request->user()->getAuthIdentifier())
                          ->where('last_activity', '>', Carbon::now()->subMinutes(config('session.lifetime'))->timestamp)
                          ->whereNotNull('previous_id')
                )
                ->orderBy('last_activity', 'desc')
                ->get()
        )->map(function ($session) use ($request) {
            $dd = $this->deviceDetector($session->user_agent);

            return (object) [
                'id' => $session->id,
                'agent' => [
                    'device' => $dd->getDeviceName(),
                    'os' => [
                        'name' => $dd->getOs('name'),
                        'version' => $dd->getOs('version'),
                    ],
                    'browser' => [
                        'name' => $dd->getClient('name'),
                        'version' => $dd->getClient('version'),
                    ],
                ],
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === $request->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });
    }
}
