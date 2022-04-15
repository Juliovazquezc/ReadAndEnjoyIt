<?php

namespace App\Listeners;

use App\Events\BookBorrowed;
use App\Models\Book;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SaveBookBorrowedHistory
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BookBorrowed $event
     * @return void
     */
    public function handle(BookBorrowed $event)
    {
        $book = $event->getBook();
        $user = $event->getUser();
        $user->historyBooks()->attach($user->id, [
            'book_id' => $book->id,
            'borrowed_date' => now(),
        ]);
    }
}
