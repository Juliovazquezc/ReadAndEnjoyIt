<?php

namespace App\Http\Requests;

use App\Constants\BookStatus;
use App\Exceptions\BookBorrowedException;
use Error;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class BorrowBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->book->status == BookStatus::AVAILABLE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            
        ];
    }

    /**
     * Throw an error if authorize method fails
     * 
     * @throws BookBorrowedException
     */
    protected function failedAuthorization()
    {
        $bookName = $this->book->name;
        $userName = $this->book-> borrowedUsers->last()->name;
        throw new BookBorrowedException(Response::HTTP_FORBIDDEN, __('error.borrowed_book', [
            'bookName' => $bookName,
            'userName' => $userName
        ]));    
    }
}
