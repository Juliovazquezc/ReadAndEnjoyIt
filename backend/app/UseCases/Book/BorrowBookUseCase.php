<?php

namespace App\UseCases\Book;

use App\Constants\BookStatus;
use App\Events\BookBorrowed;
use App\Models\Book;
use App\Models\User;
use App\Utils\UpdateModelUtil;

class BorrowBookUseCase 
{
    /**
     * @var UpdateModelUtil
     */
    protected $updateModelUtil;

    public function __construct(UpdateModelUtil $updateModelUtil) {
        $this->updateModelUtil = $updateModelUtil;
    }
    /**
     * A User borrows a book
     */
    public function __invoke(Book $book, User $user) : Book {
        $dataToUpdateBook = [
            'status' => BookStatus::BORROWED
        ];
        $this->updateModelUtil->__invoke($book, $dataToUpdateBook);
        event(new BookBorrowed($book, $user));
        return $book;
    }
}