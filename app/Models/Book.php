<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\BookFilterManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;



class Book extends Model
{
    use HasFactory;
    public $fillable = [
        'author_id',
        'publishing_id',
        'type_of_book_id',
        'title',
        'description',
        'description_small',
        'year of publication',
        'image',
        'price',
        'language',
        'views_count', // Добавляем
        'is_featured'  // Добавляем
    ];

    public function authors()
    {
        return $this->BelongsToMany(Author::class, 'author_book', 'book_id', 'author_id');
    }
    public function translators()
    {
        return $this->BelongsToMany(Translator::class, 'book_translator', 'book_id', 'translator_id');
    }
    public function reciters()
    {
        return $this->BelongsToMany(Reciter::class, 'book_reciter', 'book_id', 'reciter_id');
    }
    public function users()
    {
        return $this->BelongsToMany(User::class, 'book_user', 'book_id', 'user_id');
    }
    public function genres()
    {
        return $this->BelongsToMany(Genre::class, 'book_genre', 'book_id', 'genre_id');
    }
    public function subscription_packages()
    {
        return $this->BelongsToMany(SubscriptionPackage::class, 'book_subscription_package', 'book_id', 'subscription_package_id');
    }
    public function publishing()
    {
        return $this->belongsTo(Publishing::class, 'publishing_id');
    }
    public function type_of_book()
    {
        return $this->BelongsTo(TypeOfBook::class, 'type_of_book_id');
    }
    public function book_contents()
    {
        return $this->hasMany(BookContent::class, 'book_id');
    }
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'book_id');
    }

    protected $casts = [
        'is_featured' => 'boolean',
        'views_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getAuthorsNames(): string
    {
        if ($this->authors->isEmpty()) {
            return 'Автор не указан';
        }

        return $this->authors->pluck('full_name')->implode(', ');
    }

    /**
     * Получить первого автора (для обратной совместимости)
     */
    public function getFirstAuthorName(): string
    {
        return $this->authors->first()?->full_name ?? 'Автор не указан';
    }

    public function getFormattedCreatedAt()
    {
        return $this->created_at ? $this->created_at->format('d.m.Y') : 'Не указано';
    }

    public function getFormattedUpdatedAt()
    {
        return $this->updated_at ? $this->updated_at->format('d.m.Y') : 'Не указано';
    }

    public function getImageUrl()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default-book-cover.jpg');
    }

    public function hasAudioContent(): bool
    {
        return $this->reciters->isNotEmpty();
    }

    public function hasTranslation()
    {
        return $this->translators->isNotEmpty();
    }

    public function isAccessibleBy(User $user): bool
    {
        return $user->canAccessBook($this);
    }

    /**
     * Scope для применения фильтров
     */
    public function scopeWithFilters($query, Request $request)
    {
        return \App\Services\BookFilterManager::fromRequest($request)->apply($query);
    }

    /**
     * Scope для поиска
     */
    public function scopeSearch($query, ?string $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhereHas('authors', function ($authorQuery) use ($search) {
                    $authorQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('surname', 'like', "%{$search}%");
                });
        });
    }

    /**
     * Scope для библиотеки (только доступные книги)
     */
    public function scopeForLibrary($query)
    {
        return $query->whereHas('subscription_packages');
    }
}
