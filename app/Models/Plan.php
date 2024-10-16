<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'stripe_product_id'];

    public function prices()
    {
        return $this->hasMany(Price::class);
    }
}
