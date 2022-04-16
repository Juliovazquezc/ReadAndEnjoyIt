<?php

namespace App\Http\Requests;

use App\Constants\BookStatus;
use App\Exceptions\ReturnBookException;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class ReturnBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $book = $this->book;
        $user = $this->user();

        $userIdWithThebook = $book->borrowedUsers->last()->pivot->user_id;

        $isBookBorrowed = $this->book->status == BookStatus::BORROWED;
        $isUserWithTheBook = $user->id == $userIdWithThebook;

        return $isBookBorrowed && $isUserWithTheBook;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * Throw an error if authorize method fails
     * 
     * @throws BookBorrowedException
     */
    protected function failedAuthorization()
    {
        throw new ReturnBookException(Response::HTTP_FORBIDDEN, __('error.return_book'));    
    }
}
