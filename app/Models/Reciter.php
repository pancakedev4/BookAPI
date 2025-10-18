<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reciter extends Model
{
    //
    use HasFactory;
    public $fillable = ['name', 'surname', 'audiofile'];
    
    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_reciter', 'reciter_id', 'book_id');
    }
}
