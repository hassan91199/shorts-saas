<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtStyle extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Get the series associated with the art style.
     */
    public function series()
    {
        return $this->hasMany(Series::class);
    }
}
