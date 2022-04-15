<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    
    CONST CATEGORIES = [
        'Classic',
        'Crime',
        'Drama',
        'Horror',
        'Poetry',
        'Satire',
        'Mystery',
        'Romance',
        'Western',
        'Thriller'
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::CATEGORIES as $category ) {
            Category::create([
                'name' => $category
            ]);
        }
    }
}
