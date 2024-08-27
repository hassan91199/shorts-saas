<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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

    public function getTikTokAccessToken(): String|null
    {
        $tiktokCreds = json_decode($this->tiktok_creds) ?? null;
        $accessToken = $tiktokCreds->access_token ?? null;

        // Getting info of the user to check whether the access token is valid.
        $creatorInfoResponse = Http::asForm()->withHeaders([
            'Authorization' => "Bearer $accessToken",
            'Content-Type' => 'application/json; charset=UTF-8'
        ])->post('https://open.tiktokapis.com/v2/post/publish/creator_info/query/');

        if ($creatorInfoResponse->successful()) {
            return $accessToken;
        } else {
            // There was some problem getting the user info.
            // Getting the error code
            $creatorInfoResponseError = $creatorInfoResponse->json();
            $errorCode = $creatorInfoResponseError['error']['code'];

            // If error code is access_token_invalid it 
            // means that access token is expired and 
            // we need to refresh it.
            if ($errorCode === 'access_token_invalid') {
                $refreshTokenResponse = Http::asForm()->post('https://open.tiktokapis.com/v2/oauth/token/', [
                    'client_key' => config('tiktok.client_key'),
                    'client_secret' => config('tiktok.client_secret'),
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $tiktokCreds->refresh_token,
                ]);

                if ($refreshTokenResponse->successful()) {
                    // Save the refreshed token in the users 
                    // table and return it.
                    $refreshTokenResponseData = $refreshTokenResponse->json();
                    $this->tiktok_creds = json_encode($refreshTokenResponseData);
                    $this->save();

                    return $refreshTokenResponseData->access_token;
                }
            }
        }
        return null;
    }
}
