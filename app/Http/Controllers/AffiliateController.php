<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AffiliateController extends Controller
{
    /**
     * Display the user's affiliate info page.
     */
    public function index(Request $request): View
    {
        return view('affiliate.index', [
            'user' => $request->user(),
        ]);
    }
}
