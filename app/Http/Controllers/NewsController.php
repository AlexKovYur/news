<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        // получаем 5 сообщений из базы данных, которые являются активными и последними
        $news = News::where('active', 1)->orderBy('created_at', 'desc')->paginate(3);

        // заголовок страницы
        $title = 'Последние новости';

        //return view('home')->withNews($news)->withTitle($title);
        return view('news', compact('news','title'));
    }

    public function create(Request $request)
    {
        if ($request->user()->can_news()) {
            return view('news.create');
        } else {
            return redirect('/')->whiteErrors('У вас недостаточно прав для написания новости');
        }
    }

}
