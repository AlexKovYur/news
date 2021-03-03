<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        // получаем 5 сообщений из базы данных, которые являются активными и последними
        //$news = News::where('active', 1)->orderBy('created_at', 'desc')->paginate(3);
        $news = News::orderBy('created_at', 'desc');

        //Последние 3 новости для вывода в слайдер
        $sliderNews = $news->limit(3)->get();

        //Вывод новостей на главной странице,
        $news = $news->paginate(5);

        // заголовок страницы
        $title = 'Последние новости';

        return view('news', compact('news','sliderNews'));
    }

    public function create(Request $request)
    {
        if ($request->user()->can_news()) {
            return view('news.create');
        } else {
            return redirect('/')->whiteErrors('У вас недостаточно прав для написания новости');
        }
    }

    public function getCategoriesNews($id) {

        $categoriesNews = Category::find($id)->news;

        return view('news.category', compact('categoriesNews'));
    }

}
