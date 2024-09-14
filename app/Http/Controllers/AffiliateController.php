<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Str;

class AffiliateController extends Controller
{
    /**
     * Display the user's affiliate info page.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        if (!isset($user->referral_code)) {
            // Create a unique refer code for the user
            $code = Str::random(3);
            while (User::where('referral_code', $code)->exists()) {
                $code = Str::random(3);
            }
            $user->referral_code = $code;
            $user->save();
        }

        $affiliateUrl = config('app.url') . "/?ref=$user->referral_code";

        return view('affiliate.index', [
            'user' => $user,
            'affiliateUrl' => $affiliateUrl,
        ]);
    }

    /**
     * Update the information related to the affiliate.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validatedData = $request->validate([
            'paypal_email' => ['required', 'email', 'max:255', 'unique:users,paypal_email,' . $user->id],
        ]);

        $user->fill($validatedData);
        $user->save();

        return Redirect::route('affiliate')->with('status', 'affiliate-info-updated');
    }
}
