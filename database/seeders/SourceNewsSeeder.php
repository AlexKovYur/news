<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\Source;
use Illuminate\Database\Seeder;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class SourceNewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newsGet = News::orderBy('source', 'asc')->get();

        $newsGet = $newsGet->groupBy(function($item) {
            //Получаем host для груперовки данных
            return parse_url($item->source, PHP_URL_HOST);
        });

        foreach ($newsGet as $keyNews => $valNews) {

            $resultSource = Source::create([
                'host' => $keyNews
            ]);

            $valNews = $valNews->first();
            $valNews->source_id = $resultSource->id;
            $valNews->save();
        }

    }
}
