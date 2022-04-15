<?php

namespace App\Http\Requests;

use App\Models\Book;
use Error;
use Illuminate\Foundation\Http\FormRequest;

class EditBookRequest extends FormRequest
{
    
    protected $model;
    public function __construct(){
        $this->model = Book::find($this->route('id'));
    }
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'max:100|unique:books,name,'.$this->book->id, //Ignore the actual name of the book
            'author' => 'max:35',
            'publication_date' => 'date',
            'category_id' => 'exists:categories,id'
        ];
    }
}
