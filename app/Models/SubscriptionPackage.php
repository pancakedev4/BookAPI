<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionPackage extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'subscription_period_id',
        'name',
        'price',
        'discount_in_partner_store',
        'is_popular', // Добавляем поле
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_in_partner_store' => 'integer',
        'is_popular' => 'boolean', // Добавляем каст
    ];

    public function subscription_period()
    {
        return $this->belongsTo(SubscriptionPeriod::class, 'subscription_period_id');
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_subscription_package', 'subscription_package_id', 'book_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'subscriptions', 'subscription_package_id', 'user_id')
            ->withPivot(['start_date', 'end_date', 'status', 'payment_method', 'amount_paid'])
            ->withTimestamps();
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'subscription_package_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('price');
    }

    // Форматированная цена в BYN
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, '', ' ') . ' BYN';
    }

    // Ежемесячная цена в BYN
    public function getMonthlyPriceAttribute()
    {
        $months = $this->getMonthCount();
        if ($months > 0) {
            $monthly = $this->price / $months;
            return number_format($monthly, 0, '', ' ') . ' BYN в месяц';
        }
        return $this->formatted_price;
    }

    /**
     * Экономия в BYN
     */
    public function getSavingsAttribute(): float
    {
        // Для бесплатной подписки нет экономии
        if ($this->price == 0) {
            return 0;
        }

        $months = $this->getMonthCount();

        // Для первой платной подписки (3 месяца за 15 BYN) нет экономии
        if ($months == 3) {
            return 0;
        }

        // Берем месячную цену первой платной подписки (15 BYN / 3 месяца = 5 BYN/месяц)
        $baseMonthlyPrice = 15 / 3; // 5 BYN в месяц

        $expectedPrice = $baseMonthlyPrice * $months;
        $actualPrice = (float)$this->price;

        $savings = $expectedPrice - $actualPrice;

        return $savings > 0 ? round($savings, 2) : 0;
    }

    public function getSavingsPercentAttribute(): int
    {
        if ($this->price == 0 || $this->savings == 0) {
            return 0;
        }

        $months = $this->getMonthCount();

        $baseMonthlyPrice = 15 / 3; // 5 BYN в месяц
        $expectedPrice = $baseMonthlyPrice * $months;

        return (int)round(($this->savings / $expectedPrice) * 100);
    }

    // Вспомогательный метод для получения количества месяцев
    public function getMonthCount(): int
    {
        if (!$this->subscription_period) {
            return 1;
        }

        $title = strtolower($this->subscription_period->title);

        if (preg_match('/(\d+)\s*месяц/', $title, $matches)) {
            return (int)$matches[1];
        }

        if (preg_match('/(\d+)\s*мес/', $title, $matches)) {
            return (int)$matches[1];
        }

        if (preg_match('/(\d+)\s*год/', $title, $matches)) {
            return (int)$matches[1] * 12;
        }

        return 1;
    }

    // ДОБАВЛЕННЫЙ МЕТОД: Проверка наличия скидки у партнера
    public function hasPartnerDiscount()
    {
        return $this->discount_in_partner_store > 0;
    }

    // ДОБАВЛЕННЫЙ МЕТОД: Цвет бейджа скидки
    public function getDiscountBadgeColorAttribute()
    {
        $discount = $this->discount_in_partner_store;

        if ($discount >= 20) return 'bg-gradient-to-r from-red-500 to-pink-600';
        if ($discount >= 15) return 'bg-gradient-to-r from-orange-500 to-red-500';
        if ($discount >= 10) return 'bg-gradient-to-r from-green-500 to-teal-500';
        if ($discount >= 5) return 'bg-gradient-to-r from-blue-500 to-purple-500';

        return 'bg-gray-500';
    }

    // Популярный пакет - второй по порядку
    public function getIsPopularAttribute()
    {
        return $this->name === 'Расширенная';
    }
    /**
     * Проверка является ли подписка бесплатной
     */
    public function getIsFreeAttribute(): bool
    {
        return $this->price == 0;
    }

    /**
     * Особенности для бесплатной подписки
     */
    public function getFeaturesAttribute()
    {
        $features = [
            'Доступ ко всем книгам библиотеки',
            'Аудиоверсии книг',
            'Чтение на любых устройствах',
            'Скачивание для офлайн-чтения'
        ];

        // Для бесплатной подписки ограничиваем доступ
        if ($this->price == 0) {
            $features = [
                'Доступ к ограниченной коллекции книг',
                'Базовые функции чтения',
                'Чтение на одном устройстве',
                'Ограниченный период действия'
            ];
        }
        return $features;
    }
}
