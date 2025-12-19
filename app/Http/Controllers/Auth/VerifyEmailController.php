<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            // If already verified, check if onboarding is complete
            if (!$request->user()->onboarding_completed) {
                return redirect()->route('onboarding.step1');
            }
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        // After verification, redirect to onboarding if not completed
        if (!$request->user()->onboarding_completed) {
            return redirect()->route('onboarding.step1')->with('success', 'Email verificado com sucesso! Complete o seu perfil.');
        }

        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }
}
