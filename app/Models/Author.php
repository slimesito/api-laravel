<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Author extends Model
{
    protected $fillable = ['first_name', 'last_name', 'books_count'];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
