<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Subscription extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_package_id',
        'start_date',
        'end_date',
        'status',
        'payment_method',
        'amount_paid'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'amount_paid' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subscription_package()
    {
        return $this->belongsTo(SubscriptionPackage::class, 'subscription_package_id');
    }

    // Проверка активной подписки
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('end_date', '>', Carbon::now());
    }

    // Проверка истекших подписок
    public function scopeExpired($query)
    {
        return $query->where(function ($q) {
            $q->where('status', 'active')
                ->where('end_date', '<=', Carbon::now());
        })->orWhere('status', 'expired');
    }

    // Активна ли подписка
    public function getIsActiveAttribute()
    {
        return $this->status === 'active' && $this->end_date > Carbon::now();
    }

    // Осталось дней подписки
    public function getDaysLeftAttribute()
    {
        if (!$this->is_active) {
            return 0;
        }

        return Carbon::now()->diffInDays($this->end_date);
    }
}
