<?php

namespace App\Listeners;

use App\Events\BookReturned;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateHistoryBook
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  BookReturned  $event
     * @return void
     */
    public function handle(BookReturned $event)
    {
        $book = $event->getBook();
        $lastUserBorrowed = $book->borrowedUsers->last();
        $lastUserBorrowed->pivot->return_date = now();
        $lastUserBorrowed->pivot->save();
    }
}
