<?php

namespace App\Http\Controllers;

use App\Models\ArtStyle;
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

        $artStyles = ArtStyle::pluck('name')->toArray();

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
        $artStyle = ArtStyle::where('name', $request->get('art_style'))->first();
        $videoDuration = $request->get('video_duration');
        $applyBackgroundMusic = false;
        $title = ucwords(str_replace('_', ' ', $category));

        $prompts = Series::CATEGORY_PROMPTS;

        // Send the video generation request to VidGen Module
        $url = config('vidgen.api_base_url') . '/vid-gen';
        $data = [
            'prompt' => $prompts[$category],
            'art_style' => $artStyle->name,
            'video_duration' => $videoDuration,
            'apply_background_music' => $applyBackgroundMusic
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
            'video_duration' => $videoDuration,
            'apply_background_music' => $applyBackgroundMusic,
            'art_style_id' => $artStyle->id,
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

        $artStyles = ArtStyle::pluck('name')->toArray();

        return view('series.show', [
            'user' => $user,
            'userSeries' => $userSeries,
            'currentVideo' => $currentVideo,
            'pastVideos' => $pastVideos,
            'series' => $series,
            'artStyles' => $artStyles,
        ]);
    }

    /**
     * Display the page to show details of series.
     */
    public function update(Request $request, Series $series): RedirectResponse
    {
        dd($request->all());

        $currentVideo = $series->currentVideo();

        $newArtStyle = $request->get('art_style');
        $newVideoDuration = $request->get('video_duration');
        $newApplyBackgroundMusic = $request->get('apply_background_music');

        $reRenderVideo = false;

        $vidgenPayload = [
            'script' => $currentVideo->script,
            'art_style' => $series->artStyle->name,
            'video_duration' => $series->video_duration,
            'apply_background_music' => $series->apply_background_music
        ];

        if ($newArtStyle != $series->artStyle->name) {
            $series->art_style_id = ArtStyle::where('name', $newArtStyle)->first()->id;
            $reRenderVideo = true;

            $vidgenPayload['art_style'] = $newArtStyle;
        }

        if ($newVideoDuration != $series->video_duration) {
            $series->video_duration = $newVideoDuration;
            $reRenderVideo = true;

            $vidgenPayload['video_duration'] = $newVideoDuration;
        }

        if ($newApplyBackgroundMusic != $series->apply_background_music) {
            $series->apply_background_music = $newApplyBackgroundMusic;
            $reRenderVideo = true;

            $vidgenPayload['apply_background_music'] = $applyBackgroundMusic;
        }

        if ($reRenderVideo === true) {
            $series->video_url = null;

            dd($vidgenPayload);
        }

        $series->save();

        return redirect()->back();
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
