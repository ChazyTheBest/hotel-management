<?php

namespace App\Http\Controllers;

use App\Traits\LocalizedMarkdownResolver;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Inertia\Inertia;

class TermsOfServiceController extends Controller
{
    use LocalizedMarkdownResolver;

    /**
     * Show the terms of service for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function show(Request $request): \Inertia\Response
    {
        $termsFile = $this->localizedMarkdownPath('terms.md');

        return Inertia::render('TermsOfService', [
            'terms' => Str::markdown(file_get_contents($termsFile)),
        ]);
    }
}
