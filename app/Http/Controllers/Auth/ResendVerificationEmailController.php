<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerifyAccountMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ResendVerificationEmailController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user && ! $user->hasVerifiedEmail()) {
            Mail::to($user)->send(new VerifyAccountMail($user));
        }

        return back()->with('status', 'verification-link-sent');
    }
}
