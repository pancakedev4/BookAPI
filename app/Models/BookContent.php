<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookContent extends Model
{
    //
    use HasFactory;
    public $fillable = ['cover', 'output_information', 'contents', 'text'];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_content_id');
    }
}
