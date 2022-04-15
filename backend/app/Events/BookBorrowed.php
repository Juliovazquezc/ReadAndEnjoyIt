<?php

namespace App\Events;

use App\Models\Book;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookBorrowed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Book
     */
    protected $book;

    /**
     * @var User
     */
    protected $user;

    /**
     * Create a new event instance.
     * 
     * @param Book $book
     * @param User $user
     *
     * @return void
     */
    public function __construct(Book $book, User $user)
    {
        $this->book = $book;
        $this->user = $user;
    }

    /**
     * @return Book
     */
    public function getBook() : Book {
        return $this->book;
    }

    /**
     * @return User
     */
    public function getUser() : User {
        return $this->user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
