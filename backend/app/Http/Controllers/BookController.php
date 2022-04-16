<?php

namespace App\Http\Controllers;

use App\Constants\BookStatus;
use App\Events\BookBorrowed;
use App\Events\BookReturned;
use App\Http\Requests\AddBookRequest;
use App\Http\Requests\BorrowBookRequest;
use App\Http\Requests\EditBookRequest;
use App\Http\Requests\ReturnBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Traits\HttpResponseModelDeleted;
use App\UseCases\Book\AddNewBookUseCase;
use App\UseCases\Book\UpdateBookStatusUseCase;
use App\UseCases\Book\ReturnBookUseCase;
use App\Utils\UpdateModelUtil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    use HttpResponseModelDeleted;

    /**
     * Return a single book
     * 
     * @param Book @book
     * @return BookResource
     */
    public function show(Book $book) : BookResource {
        return new BookResource($book);
    }

    
    /**
     * Create a new book
     * 
     * @param AddBookRequest $request
     * @param AddNewBookUseCase $useCase
     * 
     * @return BookResource
     */
    public function store(AddBookRequest $request, AddNewBookUseCase $useCase) : BookResource {
        $newBook = $useCase(...$request->validated());
        return new BookResource($newBook);
    }

    /**
     * Edit a book
     * 
     * @param EditBookRequest $request,
     * @param Book $book
     * @param UpdateModelUtil $update
     * 
     * @return BookResource
     */
    public function edit(EditBookRequest $request, Book $book, UpdateModelUtil $update) : BookResource {
        $book = $update($book, $request->validated());
        return new BookResource($book);
    }

    /**
     * Delete a book
     * 
     * @param Book $book
     * 
     * @return JsonResponse
     */
    public function delete(Book $book) : JsonResponse {
        $book->delete();
        return $this->httpResponseModelDeleted();
    }

    /**
     * Borrow a book if it's available
     * @param BorrowBookRequest $request,
     * @param Book $book
     * @param UpdateBookStatusUseCase $useCase
     * 
     * @return JsonResponse
     * 
     */
    public function borrow(BorrowBookRequest $request, Book $book, UpdateBookStatusUseCase $useCase) : JsonResponse {
        $user = $request->user();
        $useCase($book, BookStatus::BORROWED, new BookBorrowed($book, $user)); 
        return response()->json([
            'message' => __('general.books.actions.borrowed', [
                'bookName' => $book->name,
                'userName' => $user->name,
            ])
        ]);
    }

    /**
     * Return a book only if the last user with the book makes the request
     * 
     * @return JsonResponse
     */
    public function return(ReturnBookRequest $request, Book $book, UpdateBookStatusUseCase $useCase) : JsonResponse {
        $useCase($book, BookStatus::AVAILABLE, new BookReturned($book)); 
        return response()->json([
            'message' => __('general.books.actions.returned')
        ]);
    }
}
