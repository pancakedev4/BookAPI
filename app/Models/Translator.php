<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Translator extends Model
{
    //
    use HasFactory;
    public $fillable = ['name', 'surname'];
    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_translator', 'translator_id', 'book_id');
    }
}
