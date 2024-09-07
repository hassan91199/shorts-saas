<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $fillable = ['plan_id', 'stripe_price_id', 'billing_cycle', 'price'];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
