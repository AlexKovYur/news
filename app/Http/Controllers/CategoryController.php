<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

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
}








