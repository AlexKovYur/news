<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function addCategories() {
        $categories = ['Мир', 'Политика', 'Наука', 'Спорт',
            'Здоровье', 'Культура', 'Наука', 'Происшествия', 'Экономика'];

        foreach ($categories as $keyCategory => $category) {
            $category = Category::create([
                'name' => $category,
            ]);
        }
    }

    public function deleteAllCategories() {
        // отключаем проверку внешнего ключа для этого соединения перед запуском сидеров
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Category::truncate();

        // применяем только к одному соединению и сбрасывать его самостоятельно
        // явно отменить то, что я сделали
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}








