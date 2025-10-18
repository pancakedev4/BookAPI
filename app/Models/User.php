<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_user', 'user_id', 'book_id');
    }
    // Связь с подписками через промежуточную таблицу
    public function subscription_packages()
    {
        return $this->belongsToMany(SubscriptionPackage::class, 'subscriptions', 'user_id', 'subscription_package_id')
            ->withPivot(['start_date', 'end_date', 'status', 'payment_method', 'amount_paid'])
            ->withTimestamps();
    }

    // Связь с моделью Subscription (ОДНА ИЗ ЭТИХ ДВУХ ДОЛЖНА БЫТЬ!)
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'user_id');
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'user_id');
    }

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Проверка доступа к книге
     */
    public function canAccessBook(Book $book): bool
    {
        // Если у пользователя активная подписка - доступ ко всем книгам
        return $this->has_active_subscription;
    }

    /**
     * Проверка наличия активной подписки
     */
    public function getHasActiveSubscriptionAttribute(): bool
    {
        return $this->active_subscription !== null;
    }

    /**
     * Активная подписка пользователя
     */
    public function active_subscription()
    {
        return $this->hasOne(Subscription::class, 'user_id')
            ->where('status', 'active')
            ->where('end_date', '>', Carbon::now())
            ->latest();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
