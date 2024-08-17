<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Series extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'series';

    protected $fillable = [
        'user_id',
        'title',
        'category',
        'destination',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function currentVideo()
    {
        return $this->videos()->where('is_current', true)->first();
    }

    public function pastVideos()
    {
        return $this->videos()->where('is_current', false)->get();
    }
}
