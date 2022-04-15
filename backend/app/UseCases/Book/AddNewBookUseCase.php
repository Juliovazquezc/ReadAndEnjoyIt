<?php

namespace App\UseCases\Book;

use App\Models\Book;

class AddNewBookUseCase 
{

    /**
     * Create a new book
     * 
     * @param string $name
     * @param string $author
     * @param string $publication_date - format => YYYY/MM/DD
     * @param int $category_id
     */
    public function __invoke(string $name, string $author, string $publication_date, int $category_id) :Book {
        $book = Book::create([
            'name' => $name,
            'author' => $author,
            'publication_date' => $publication_date,
            'category_id' => $category_id
        ]);

        return $book;
    }
}