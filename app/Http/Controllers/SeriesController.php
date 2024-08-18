<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use App\Models\Series;
use Illuminate\Http\RedirectResponse;

class SeriesController extends Controller
{
    /**
     * Redirects the user to their first series 
     * page, or displays the index page if no 
     * series are found.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(): RedirectResponse|View
    {
        $user = auth()->user();

        $userSeries = $user->series->first();

        if ($userSeries) {
            return redirect()->route('series.show', ['series' => $userSeries->id]);
        } else {
            return view('series.index');
        }
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
     * @return Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $destination = $request->get('destination');
        $category = $request->get('category');
        $title = ucwords(str_replace('_', ' ', $category));

        $descriptions = [
            'interesting_history' => 'Please share a concise and captivating account of a highly interesting, yet lesser-known historical event. The event MUST be real, factual, and found on Wikipedia. Begin with a captivating introduction or question to hook the audience. Your goal is to fascinate and inform the audience on interesting history.'
        ];

        // Send the video generation request to VidGen Module
        $url = 'http://localhost:31415/vid-gen';
        $data = [
            'description' => $descriptions[$category]
        ];
        $response = Http::post($url, $data);
        $responseData  = $response->json();

        $videoData = [
            'vid_gen_id' => $responseData['video_id'] ?? null,
            'title' => $responseData['title'] ?? '',
            'caption' => $responseData['caption'] ?? '',
            'script' => $responseData['script'] ?? '',
        ];

        // Create a new Series record
        $series = Series::create([
            'user_id' => auth()->id(),
            'title' => $title,
            'category' => $category,
            'destination' => $destination,
        ]);

        // Create new video and associate it with series
        $series->videos()->create($videoData);

        return redirect()->route('series.show', ['series' => $series->id]);
    }

    /**
     * Display the page to show details of series.
     */
    public function show(Request $request, Series $series): View
    {
        $user = auth()->user();

        $userSeries = $user->series;

        $currentVideo = $series->currentVideo();
        $pastVideos = $series->pastVideos();


        return view('series.show', [
            'user' => $user,
            'userSeries' => $userSeries,
            'currentVideo' => $currentVideo,
            'pastVideos' => $pastVideos,
            'series' => $series,
        ]);
    }
}
