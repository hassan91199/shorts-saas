<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class SeriesController extends Controller
{
    /**
     * Display the page to create a series.
     */
    public function index(Request $request): View
    {
        return view('series.view');
    }
    
    /**
     * Display the page to create a series.
     */
    public function create(Request $request): View
    {
        return view('series.create');
    }

    /**
     * Store a newly created series in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function store(Request $request): View
    {
        // $destination = $request->get('destination');
        // $category = $request->get('category');

        // $description = "Create a dynamic and engaging short video that captures the essence of $category. The video should be visually appealing, with a mix of vibrant colors, smooth transitions, and energetic background music. Incorporate key elements and visuals that represent the core themes of $category, while maintaining a playful and entertaining tone. The video should be concise yet impactful, with a focus on creating a memorable experience for the viewer.";

        // $url = 'http://localhost:31415/vid-gen';
        // $data = [
        //     'description' => $description
        // ];

        // $response = Http::post($url, $data);

        // dd($response);

        return view('series.view');
    }
}
