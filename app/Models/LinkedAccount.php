<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkedAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'provider_name',
        'provider_account_id',
        'access_token',
        'refresh_token',
        'access_token_expires_at',
        'refresh_token_expires_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isTokenExpired()
    {
        return $this->access_token_expires_at && $this->access_token_expires_at <= now();
    }

    public function isRefreshTokenExpired()
    {
        return $this->refresh_token_expires_at && $this->refresh_token_expires_at <= now();
    }
}
