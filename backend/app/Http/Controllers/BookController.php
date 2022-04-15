<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddBookRequest;
use App\Http\Requests\EditBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Traits\HttpResponseModelDeleted;
use App\UseCases\Book\AddNewBookUseCase;
use App\Utils\UpdateModelUtil;
use Illuminate\Http\JsonResponse;

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
}
