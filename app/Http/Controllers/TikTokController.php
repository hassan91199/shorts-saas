<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class TikTokController extends Controller
{
    public function redirectToTikTok(Request $request)
    {
        // Generating random string for code verifier
        $codeVerifier = bin2hex(random_bytes(32));
        // Save the code_verifier in a cookie or session for later use
        Cookie::queue('code_verifier', $codeVerifier, 10);

        // Generating the code_challenge from the code_verifier
        $codeChallenge = strtr(rtrim(base64_encode(hash('sha256', $codeVerifier, true)), '='), '+/', '-_');

        // Generate a random CSRF state token
        $csrfState = bin2hex(random_bytes(16));
        // Save the CSRF state token in a cookie with a 60-sec expiration
        Cookie::queue('csrfState', $csrfState, 1);

        // Buil the TikTok authorization URL
        $url = 'https://www.tiktok.com/v2/auth/authorize/';
        $params = [
            'client_key' => config('tiktok.client_key'),
            'scope' => 'user.info.basic',
            'response_type' => 'code',
            'redirect_uri' => 'https://6vgfj1l.localto.net/auth/tiktok/callback/',
            'state' => $csrfState,
            'code_challenge' => $codeChallenge,
            'code_challenge_method' => 'S256'
        ];

        // Append the parameters to the URL
        $authUrl = $url . '?' . http_build_query($params);

        return redirect($authUrl);
    }

    public function handleTikTokCallback(Request $request)
    {
        //
    }
}
