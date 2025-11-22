<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Book extends Model
{
    protected $fillable = ['title', 'description', 'published_date', 'author_id'];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
