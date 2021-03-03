<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\News;
use App\Models\User;
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

        //Создаем 3 новости и пользователя
        $news = News::factory()
            ->count(3)
            ->for(User::factory(), 'author')
            ->create();

        //Привязываем категорию к пользователю
        $news->each(function ($news) use ($category) {
            $createdAt  = $news->created_at;
            $updatedAt  = $news->updated_at;

            $news->categories()->attach(
                $category->random(rand(1,1))->pluck('id')->toArray(),
                ['created_at' => $createdAt, 'updated_at' => $updatedAt]
            );

        });
    }
}
