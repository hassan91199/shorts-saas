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
        return $this->hasMany(User::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
