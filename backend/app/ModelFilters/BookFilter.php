<?php 

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class BookFilter extends ModelFilter
{
    public function search($q) {
        $term = "%$q%";
         return $this->orWhere('name', 'LIKE', $term)
            ->orWhere('author', 'LIKE', $term)
            ->orWhere('status', 'LIKE', $term)
            ->orWhere('publication_date', 'LIKE', $term)
            ->orWhereHas('category', function($query) use ($term) {
                $query->where('name', 'LIKE', $term);
            });
    }
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [
    ];
}
