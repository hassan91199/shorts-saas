<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class SeriesController extends Controller
{
    /**
     * Display the page to create a series.
     */
    public function create(Request $request): View
    {
        return view('series.create');
    }
}
