<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Publishing extends Model
{
    //
    use HasFactory;
    public $fillable = ['title'];

    public function books()
    {
        return $this->hasMany(Book::class, 'publishing_id');
    }
}
