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

    public const CATEGORY_PROMPTS = [
        'interesting_history' => 'Please share a concise and captivating account of a highly interesting, yet lesser-known historical event. The event MUST be real, factual, and found on Wikipedia. Begin with a captivating introduction or question to hook the audience. Your goal is to fascinate and inform the audience on interesting history.',
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
