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
        'token_expires_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isTokenExpired()
    {
        return $this->token_expires_at && $this->token_expires_at <= now();
    }
}
