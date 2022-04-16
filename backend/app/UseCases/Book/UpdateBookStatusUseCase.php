<?php

namespace App\UseCases\Book;

use App\Constants\BookStatus;
use App\Events\BookBorrowed;
use App\Models\Book;
use App\Models\User;
use App\Utils\UpdateModelUtil;

class UpdateBookStatusUseCase 
{
    /**
     * @var UpdateModelUtil
     */
    protected $updateModelUtil;

    public function __construct(UpdateModelUtil $updateModelUtil) {
        $this->updateModelUtil = $updateModelUtil;
    }
    /**
     * Change the book status and trigger an event
     * 
     * @return Book
     */
    public function __invoke(Book $book, string $status, object $eventToTrigger) : Book {
        $dataToUpdateBook = [
            'status' => $status
        ];
        $this->updateModelUtil->__invoke($book, $dataToUpdateBook);
        event($eventToTrigger);
        return $book;
    }
}