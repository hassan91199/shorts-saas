<?php

use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TikTokController;
use App\Http\Controllers\YouTubeController;
use App\Models\User;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Http\Controllers\WebhookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function (Request $request) {
    $referralCode = $request->query('ref');

    if (isset($referralCode)) {
        session(['referral_code' => $referralCode]);

        $referrer = User::where('referral_code', $referralCode)->first();

        if ($referrer) {
            $referrer->increment('referral_clicks');
        }
    }

    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    return redirect()->route('series.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/update-account', [ProfileController::class, 'updateAccount'])->name('account.update');

    Route::get('/series/create', [SeriesController::class, 'create'])->name('series.create');
    Route::post('/series', [SeriesController::class, 'store'])->name('series.store');
    Route::get('/series', [SeriesController::class, 'index'])->name('series.index');
    Route::get('/series/{series}', [SeriesController::class, 'show'])->name('series.show');
    Route::put('/series/{series}', [SeriesController::class, 'update'])->name('series.update');
    Route::delete('/series/{series}', [SeriesController::class, 'destroy'])->name('series.destroy');

    Route::get('/auth/youtube', [YouTubeController::class, 'redirectToYoutube'])->name('youtube.auth');
    Route::get('/auth/youtube/callback', [YouTubeController::class, 'handleYoutubeCallback'])->name('youtube.callback');

    Route::get('/auth/tiktok', [TikTokController::class, 'redirectToTikTok'])->name('tiktok.auth');
    Route::get('/auth/tiktok/callback', [TikTokController::class, 'handleTikTokCallback'])->name('tiktok.callback');

    Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscribe');
    Route::post('/unsubscribe', [SubscriptionController::class, 'unsubscribe'])->name('unsubscribe');
    Route::get('/billing', [SubscriptionController::class, 'billing'])->name('billing');

    Route::get('/billing-portal', function (Request $request) {
        return auth()->user()->redirectToBillingPortal(route('billing'));
    })->name('billing.portal');

    Route::get('/affiliate', [AffiliateController::class, 'index'])->name('affiliate');
    Route::patch('/affiliate', [AffiliateController::class, 'update'])->name('affiliate.update');
});


Route::post('/stripe/webhook', [WebhookController::class, 'handleWebhook'])->name('cashier.webhookapp/Http/Controllers/SubscriptionController.php');

require __DIR__ . '/auth.php';
