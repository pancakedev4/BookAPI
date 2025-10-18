<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionPeriod extends Model
{
    //
    use HasFactory;
    protected $fillable = ['title', 'discount_amount'];

    protected $casts = [
        'discount_amount' => 'integer',
    ];

    public function subscription_packages()
    {
        return $this->hasMany(SubscriptionPackage::class, 'subscription_period_id');
    }

    public function getFormattedDiscountAttribute()
    {
        return $this->discount_amount . '%';
    }
}
