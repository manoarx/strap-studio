<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->with(['access_type' => 'offline'])->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();

        // $user->token;
        // $user->refreshToken;
        // $user->expiresIn;

        // Store user data and refresh token in your database

        return redirect('/')->with('success', 'Google authentication successful!');
    }
}
