<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;
use Faker\Factory;

class SourceNewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $news = News::all();

        $news->each(function ($news_update, $key) {
            $faker = Factory::create();

            $news_update->source = $faker->url;

            $news_update->save();
        });
    }
}
