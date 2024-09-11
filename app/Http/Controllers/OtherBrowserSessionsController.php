<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Actions\ConfirmPassword;

class OtherBrowserSessionsController extends Controller
{
    /**
     * Log out from other browser sessions.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\StatefulGuard $guard
     * @param string|null $sessionId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException|\Illuminate\Auth\AuthenticationException
     */
    public function destroy(Request $request, StatefulGuard $guard, ?string $sessionId = null): \Illuminate\Http\RedirectResponse
    {
        $confirmed = app(ConfirmPassword::class)(
            $guard, $request->user(), $request->password
        );

        if (! $confirmed) {
            throw ValidationException::withMessages([
                'password' => __('The password is incorrect.'),
            ]);
        }

        if ($sessionId) {
            // Delete specific sessions
            $sessionIds = explode(',', $sessionId);
            $this->deleteSessionRecords($request, $sessionIds);
        } else {
            // Delete all other sessions
            $guard->logoutOtherDevices($request->password);
            $this->deleteOtherSessionRecords($request);
        }

        return back(303);
    }

    /**
     * Delete specific session records.
     *
     * @param \Illuminate\Http\Request $request
     * @param array $sessionIds
     * @return void
     */
    protected function deleteSessionRecords(Request $request, array $sessionIds): void
    {
        if (config('session.driver') !== 'database') {
            return;
        }

        $this->getQuery()
            ->where('user_id', $request->user()->getAuthIdentifier())
            ->where('id', '!=', $request->session()->getId())
            ->whereIn('id', $sessionIds)
            ->delete();
    }

    /**
     * Delete the other browser session records from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function deleteOtherSessionRecords(Request $request): void
    {
        if (config('session.driver') !== 'database') {
            return;
        }

        $this->getQuery()
            ->where('user_id', $request->user()->getAuthIdentifier())
            ->where('id', '!=', $request->session()->getId())
            ->delete();
    }

    private function getQuery(): Builder
    {
        return DB::connection(config('session.connection'))
            ->table(config('session.table', 'sessions'));
    }
}
