<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'videos';

    protected $fillable = [
        'series_id',
        'vid_gen_id',
        'title',
        'caption',
        'script',
        'video_url',
        'youtube_video_id',
        'render_percentage',
        'is_current',
    ];

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function user()
    {
        return $this->hasOneThrough(User::class, Series::class, 'id', 'id', 'series_id', 'user_id');
    }
}
