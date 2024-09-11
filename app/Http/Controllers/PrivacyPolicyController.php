<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Traits\LocalizedMarkdownResolver;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PrivacyPolicyController extends Controller
{
    use LocalizedMarkdownResolver;

    /**
     * Show the privacy policy for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function show(Request $request): \Inertia\Response
    {
        $policyFile = $this->localizedMarkdownPath('policy.md');

        return Inertia::render('PrivacyPolicy', [
            'policy' => Str::markdown(file_get_contents($policyFile)),
        ]);
    }
}
