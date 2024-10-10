<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use App\Models\Series;
use Carbon\Carbon;
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
    public function index(Request $request): RedirectResponse|View
    {
        $user = auth()->user();

        if ($request->has('checkout') && $request->input('checkout') === 'success') {
            $subscriptions = $user->subscriptions()->active()->get();

            if ($subscriptions->count() > 1) {
                // Get the latest subscription
                $latestSubscription = $subscriptions->sortByDesc('created_at')->first();

                // Cancel all subscriptions except the latest one
                foreach ($subscriptions as $subscription) {
                    if ($subscription->id !== $latestSubscription->id) {
                        $subscription->cancelNow();
                    }
                }
            }

            $allSubscriptions = $user->subscriptions()->get();

            // Check if this is the user's first subscription
            if ($allSubscriptions->count() === 1) {
                // User has subscribed for the first time
                $referrer = $user->referrer;

                if ($referrer) {
                    // Check if the user registered within the last 30 days
                    $registeredWithin30Days = $user->created_at >= Carbon::now()->subDays(30);

                    if ($registeredWithin30Days) {
                        // Increment the conversions count of the referrer
                        $referrer->increment('referral_conversions');

                        // Mark this as the successful conversion for the referrer
                        $user->referrer_successful_conversion = true;
                        $user->save();
                    }
                }
            }
        }

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
        $user = auth()->user();

        $seriesCategories = Series::CATEGORY_PROMPTS;

        $maxSeries = $user->subscriptions()?->active()?->first()->quantity ?? 1;
        $userSeries = $user->series()->withTrashed()->count();

        $seriesLimitReached = $userSeries >= $maxSeries;

        $artStyles = [
            'normal',
            'comic_book',
            'disney_toon',
            'studio_ghibli',
            'childrens_book',
            'photo_realism',
            'minecraft',
            'watercolor',
            'expressionism',
            'charcoal',
            'anime',
            'normal_v2',
        ];

        return view('series.create', [
            'seriesCategories' => $seriesCategories,
            'seriesLimitReached' => $seriesLimitReached,
            'artStyles' => $artStyles,
        ]);
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

        $descriptions = Series::CATEGORY_PROMPTS;

        // Send the video generation request to VidGen Module
        $url = config('vidgen.api_base_url') . '/vid-gen';
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

    /**
     * Soft delete the series and its related videos
     * 
     * @param Series $series The series to delete
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Series $series): RedirectResponse
    {
        // Soft delete all the related videos in the series
        $series->videos()->delete();

        // Soft delete the series
        $series->delete();

        return redirect()->route('series.index')->with('success', 'Series deleted successfully');
    }
}
