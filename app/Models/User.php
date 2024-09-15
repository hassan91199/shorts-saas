<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'youtube_token',
        'paypal_email',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function series()
    {
        return $this->hasMany(Series::class);
    }

    public function videos()
    {
        return $this->hasManyThrough(
            Video::class,
            Series::class,
            'user_id',
            'series_id',
            'id',
            'id'
        );
    }

    public function getTikTokAccessToken(): ?string
    {
        $tiktokCreds = json_decode($this->tiktok_creds, true);

        if (
            empty($tiktokCreds) ||
            !array_key_exists('access_token', $tiktokCreds) ||
            empty($tiktokCreds['access_token'])
        ) return null;

        $accessToken = $tiktokCreds['access_token'];

        $accessTokenExpiryTime = $tiktokCreds['created'] + $tiktokCreds['expires_in'];
        $isAccessTokenExpired = time() > $accessTokenExpiryTime;

        if ($isAccessTokenExpired) {
            // Ensure refresh token exists before proceeding
            if (empty($tiktokCreds['refresh_token'])) return null;

            $refreshTokenExpiryTime = $tiktokCreds['created'] + $tiktokCreds['refresh_expires_in'];
            $isRefreshTokenExpired = time() > $refreshTokenExpiryTime;

            if ($isRefreshTokenExpired) return null;

            $refreshTokenResponse = Http::asForm()->post('https://open.tiktokapis.com/v2/oauth/token/', [
                'client_key' => config('tiktok.client_key'),
                'client_secret' => config('tiktok.client_secret'),
                'grant_type' => 'refresh_token',
                'refresh_token' => $tiktokCreds['refresh_token'],
            ]);

            if ($refreshTokenResponse->successful()) {
                // Save the refreshed token in the users table and return it
                $refreshTokenResponseData = $refreshTokenResponse->json();
                $refreshTokenResponseData['created'] = time();
                $this->tiktok_creds = json_encode($refreshTokenResponseData);
                $this->save();

                return $refreshTokenResponseData['access_token'] ?? null;
            }
        } else {
            return $accessToken;
        }
        return null;
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    public function referees()
    {
        return $this->hasMany(User::class, 'referred_by');
    }
}
