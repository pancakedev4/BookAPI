<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    //
    use HasFactory;
    public $fillable = ['title', 'parent_id'];

    public function genres()
    {
        return $this->hasMany(Genre::class, 'category_id');
    }
}
