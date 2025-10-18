<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends Model
{
    //
    use HasFactory;
    public $fillable = ['name', 'surname', 'author_id'];

    public function books()
    {
        return $this->belongsToMany(Book::class, 'author_book', 'author_id', 'book_id');
    }

    public function getFullName(): string
    {
        return trim($this->name . ' ' . $this->surname);
    }

    /**
     * Accessor для полного имени
     */
    public function getFullNameAttribute(): string
    {
        return $this->getFullName();
    }
}
