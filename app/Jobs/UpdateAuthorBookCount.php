<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Author;

class UpdateAuthorBookCount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $authorId;

    public function __construct($authorId)
    {
        $this->authorId = $authorId;
    }

    public function handle()
    {
        $author = Author::find($this->authorId);
        if ($author) {
            // Recalcular conteo real para consistencia
            $count = $author->books()->count();
            $author->update(['books_count' => $count]);
        }
    }
}
