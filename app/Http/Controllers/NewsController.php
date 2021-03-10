<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    private function newsGroupBy() {
        //перед выполнение GROUP BY что бы не добавлять ВСЕ неаггрегированные поля выборки, необходимо сбросить sql_mode
        DB::statement("SET SQL_MODE=''");

        //Сгрупированные новости для вывода в боковую панель
        $monthYearNews = News::selectRaw('id, year(news_date) year, monthname(news_date) month')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->get();

        return $monthYearNews;
    }

    public function index()
    {
        // получаем 5 сообщений из базы данных, которые являются активными и последними
        $news = News::orderBy('created_at', 'desc');

        //Последние 3 новости для вывода в слайдер
        $sliderNews = $news->limit(3)->get();

        $monthYearNews = NewsController::newsGroupBy();

        //Вывод новостей на главной странице,
        $news = $news->paginate(5);

        // заголовок страницы
        $title = 'Последние новости';

        return view('news', compact('news','sliderNews', 'monthYearNews'));
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

        $monthYearNews = NewsController::newsGroupBy();

        $categoriesNews = Category::find($id)->news;

        return view('news.category', compact('categoriesNews', 'monthYearNews'));
    }

    public function getNewsGroupBy($id) {
        //Получает все новости категории
        $categoriesNews = News::select('*')->where('id', $id)->get();

        $monthYearNews = NewsController::newsGroupBy();

        return view('news.category', compact('categoriesNews', 'monthYearNews'));

    }

}
