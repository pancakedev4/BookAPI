<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    //
    use HasFactory;
    public $fillable = ['name'];

        public function users()
    {
        return $this->hasMany(User::class, 'users', 'role_id');
    }
}
