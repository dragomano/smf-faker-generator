<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BoardSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();

        $categories->each(
            fn($category) => Board::factory(mt_rand(1, 2))
                ->sequence(fn() => ['id_cat' => $category->id_cat])
                ->create()
        );
    }
}
