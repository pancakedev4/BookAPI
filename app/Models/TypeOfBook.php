<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TypeOfBook extends Model
{
    //
    use HasFactory;
    public $fillable = ['type'];

        public function books()
    {
        return $this->hasMany(Book::class, 'type_of_book_id');
    }
}
