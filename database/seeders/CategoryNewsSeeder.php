<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\News;
use Illuminate\Database\Seeder;

class CategoryNewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = Category::all();

        News::all()->each(function ($news) use ($category) {
            $createdAt  = $news->created_at;
            $updatedAt  = $news->updated_at;

            $news->categories()->attach(
                $category->random(rand(1, 9))->pluck('id')->toArray(),
                ['created_at' => $createdAt, 'updated_at' => $updatedAt]
            );

        });
    }
}
