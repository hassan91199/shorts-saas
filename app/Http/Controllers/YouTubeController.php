<?php

namespace App\Http\Controllers;

use Google_Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class YouTubeController extends Controller
{
    public function redirectToYoutube(Request $request)
    {
        // Initialize Google Client
        $client = $this->getGoogleClient();
        $authUrl = $client->createAuthUrl();

        // Redirect the user to Google's OAuth consent page
        return redirect()->away($authUrl);
    }

    public function handleYoutubeCallback(Request $request)
    {
        $client = $this->getGoogleClient();
        $authCode = $request->get('code');
        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

        // Save the access token to the user's account (e.g, in the database)
        $user = Auth::user();
        $user->youtube_token = json_encode($accessToken);
        $user->save();

        return redirect()->route('series.index');
    }

    private function getGoogleClient()
    {
        $client = new Google_Client();
        $client->setClientId(config('google.client_id'));
        $client->setClientSecret(config('google.client_secret'));
        $client->setRedirectUri(config('google.redirect_uri'));
        $client->addScope(config('google.scopes.youtube'));
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        return $client;
    }
}
