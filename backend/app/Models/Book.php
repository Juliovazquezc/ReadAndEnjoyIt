<?php

namespace App\Models;

use App\Constants\BookStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use EloquentFilter\Filterable;

class Book extends Model
{
    use HasFactory, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'author',
        'category_id',
        'publication_date',
        'status'
    ];

     /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
        'status' => BookStatus::AVAILABLE
    ];

    /**
     * Return the category book
     * 
     * @return Category
     */
    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Return the last user with the book
     */
    public function userWithTheBook () {
        return ( count($this->borrowedUsers) > 0 ) ? $this->borrowedUsers->last()->name: '';    
    }

    public function iduserWithTheBook () {
        return ( count($this->borrowedUsers) > 0 ) ? $this->borrowedUsers->last()->pivot->user_id: '';    
    }

    /**
     * Return an array of users with fields of pivot table
     * 
     */
    public function borrowedUsers() {
        return $this->belongsToMany(User::class, 'users_history_books')
            ->withPivot('id', 'borrowed_date', 'return_date');
    }
}
