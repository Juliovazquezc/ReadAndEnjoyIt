<?php

namespace App\Http\Resources;

use App\Constants\BookStatus;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
           'id'=> $this->id,
           'name' => $this->name,
           'author' => $this->author,
           'status' => $this->status,
           'user_with_the_book' => $this->when($this->status == BookStatus::BORROWED, $this->userWithTheBook()), 
           'publication_date' => $this->publication_date,
           'category' => $this->category->name,
        ];
    }
}
