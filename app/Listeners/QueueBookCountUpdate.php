<?php

namespace App\Listeners;

use App\Events\BookCreated;
use App\Jobs\UpdateAuthorBookCount;
use Illuminate\Contracts\Queue\ShouldQueue;

class QueueBookCountUpdate
{
    public function handle(BookCreated $event)
    {
        // Despachar el Job a la cola
        dispatch(new UpdateAuthorBookCount($event->book->author_id));
    }
}
