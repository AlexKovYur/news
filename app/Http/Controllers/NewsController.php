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

    private function sourceHost($news) {
        $arrayUrlByNews = !empty($news->source) ? parse_url($news->source) : [];
        $host = !empty($arrayUrlByNews['host']) ? $arrayUrlByNews['host'] : '';

        return $host;
    }

    public function index()
    {
        //Массив новостей по категориям
        $arrayTwoNewsByCategory = [];

        //Массив url по новостям
        $arrayHostByNews = [];

        // получаем 5 сообщений из базы данных, которые являются активными и последними
        $news = News::orderBy('created_at', 'desc');

        //Последние 3 новости для вывода в слайдер
        $sliderNews = $news->limit(3)->get();

        //Сгрупированные новости по месяцу и году для вывода в боковую панель
        $monthYearNews = NewsController::newsGroupBy();

        //Вывод новостей на главной странице,
        //$news = $news->paginate(5);

        //Все категории
        $categoriesAll = Category::get();

        if (!empty($categoriesAll)) {
            foreach ($categoriesAll as $keyCategories => $valCategories) {

                $twoNewsByCategory = $valCategories->twoNews()->get();

                $fourNewsByCategory = $valCategories->fourNewsSkipTwo()->get();

                if (empty($twoNewsByCategory)) {
                   continue;
                }

                $arrayTwoNewsByCategory[$keyCategories] = $twoNewsByCategory;

                $arrayFourNewsByCategory[$keyCategories] = $fourNewsByCategory;

                foreach ($twoNewsByCategory as $keyNewsByCategory => $valNewsByCategory) {
                    /*$arrayUrlByNews = !empty($valNewsByCategory->source) ? parse_url($valNewsByCategory->source) : [];
                    $hostNews = !empty($arrayUrlByNews['host']) ? $arrayUrlByNews['host'] : '';*/

                    $hostNews = NewsController::sourceHost($valNewsByCategory);

                    if (!empty($hostNews)) {
                        $arrayHostByNews[$keyCategories][$keyNewsByCategory] = $hostNews;
                    }
                }


            }
        }
        //dd($arrayHostByNews);
        // заголовок страницы
        $title = 'Последние новости';

        return view('news',
            compact('news',
                'sliderNews',
                'monthYearNews',
                'categoriesAll',
                'arrayTwoNewsByCategory',
                'arrayHostByNews',
                'arrayFourNewsByCategory'));
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

        $categoriesNews = Category::find($id)->news()->paginate(5);

        return view('news.category', compact('categoriesNews', 'monthYearNews'));
    }

    public function getNewsGroupBy($id) {
        //Получает все новости категории
        $categoriesNews = News::select('*')->where('id', $id)->get();

        $monthYearNews = NewsController::newsGroupBy();

        return view('news.category', compact('categoriesNews', 'monthYearNews'));

    }

    //Получаем данные новости по id
    public function getNews($id) {
        if (!empty($id)) {
            $foundNews = News::find($id);

            $monthYearNews = NewsController::newsGroupBy();

            //Если данные по новость есть то выводим новость, иначе перенаправляем обратно
            if (!empty($foundNews)) {
                $hostNews = NewsController::sourceHost($foundNews);

                return view('news.one_news', compact('foundNews', 'monthYearNews', 'hostNews'));
            } else {
                return back();
            }
        } else {
            return back();
        }
    }

}
