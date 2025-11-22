<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use App\Models\Book;

class BookCreated
{
    use SerializesModels;

    public $book;

    public function __construct(Book $book)
    {
        $this->book = $book;
    }
}
