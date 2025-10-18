<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use PhpParser\Node\Expr\FuncCall;

class Feedback extends Model
{
    //
    use HasFactory;
    public $fillable = ['book_id', 'user_id', 'book rating', 'book review'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
