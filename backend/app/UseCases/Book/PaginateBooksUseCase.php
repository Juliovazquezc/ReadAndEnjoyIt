<?php

namespace App\UseCases\Book;

use App\Constants\Pagination;
use App\Models\Book;

class PaginateBooksUseCase
{
    /**
     * Paginate books with a query
     * 
     * @param array $queryParams
     */
    public function __invoke(array $queryParams) {
        $limit = array_key_exists('limit', $queryParams) ? $queryParams['limit'] : Pagination::ITEMS_PER_PAGE;
        $page = array_key_exists('page', $queryParams) ? $queryParams['page'] : Pagination::DEFAULT_PAGE;
        $sortBy = array_key_exists('sortBy', $queryParams) ? $queryParams['sortBy'] : Pagination::DEFAULT_SORT_BY;
        $search = array_key_exists('search', $queryParams) ? $queryParams['search'] : '';
        $desc = $this->setDescAttribute($queryParams);
        $books = Book::orderBy($sortBy, $desc)
            ->filter(['page' => $page,
            'search' => $search])
            ->paginate($limit);
        return $books;
    }

    private function setDescAttribute($queryParams) {
        $exists =  array_key_exists('desc', $queryParams) ? true: false;
        if(!$exists) {
            return 'ASC';
        }
        $boolVal = ($queryParams['desc'] === 'true') ? true : false;
        if($boolVal){
            return 'DESC';
        }else {
            return 'ASC';
        }
    }
} 