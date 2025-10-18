<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Genre extends Model
{
    //
    use HasFactory;
    public $fillable = ['title'];

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_genre', 'genre_id', 'book_id');
    }
        public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
