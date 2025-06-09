<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Book extends Model
{
    use HasFactory;
    public $fillable = ['name', 'body', 'body_small', 'picture', 'type', 'price'];
    
}


