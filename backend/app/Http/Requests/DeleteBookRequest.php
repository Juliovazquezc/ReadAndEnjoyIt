<?php

namespace App\Http\Requests;

use App\Constants\BookStatus;
use App\Exceptions\BookNotAvailableToDeleteException;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class DeleteBookRequest extends FormRequest
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
            //
        ];
    }

    /**
     * Throw an error if authorize method fails
     * 
     * @throws BookNotAvailableToDeleteException
     */
    protected function failedAuthorization()
    {
        throw new BookNotAvailableToDeleteException(Response::HTTP_FORBIDDEN, __('error.delete_book'));
    }
}
