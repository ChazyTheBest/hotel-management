<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AccountPhotoController extends Controller
{
    /**
     * Delete the current user's account photo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->user()->deleteAccountPhoto();

        return back(303)->with('status', 'profile-photo-deleted');
    }
}
