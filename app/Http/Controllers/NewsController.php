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

    private function newsGroupByWhereSourceId($sourceId) {
        //перед выполнение GROUP BY что бы не добавлять ВСЕ неаггрегированные поля выборки, необходимо сбросить sql_mode
        DB::statement("SET SQL_MODE=''");

        //Сгрупированные новости для вывода в боковую панель
        $monthYearNewsWhereSouceId = News::selectRaw('id, year(news_date) year, monthname(news_date) month')
            ->where('source_id', $sourceId)
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->get();

        return $monthYearNewsWhereSouceId;
    }

    /*private function newsGroupByWhereCategoriesId($sourceId) {
        //перед выполнение GROUP BY что бы не добавлять ВСЕ неаггрегированные поля выборки, необходимо сбросить sql_mode
        DB::statement("SET SQL_MODE=''");

        //Сгрупированные новости для вывода в боковую панель
        $monthYearNewsWhereSouceId = News::selectRaw('id, year(news_date) year, monthname(news_date) month')
            ->where('source_id', $sourceId)
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->get();

        return $monthYearNewsWhereSouceId;
    }*/

    private function sourceHost($news) {
        $arrayUrlByNews = !empty($news->source) ? parse_url($news->source) : [];
        $host = !empty($arrayUrlByNews['host']) ? $arrayUrlByNews['host'] : '';

        return $host;
    }

    public function index()
    {
        //Массив новостей по категориям
        //$arrayTwoNewsByCategory = [];

        //Массив url по новостям
        $arrayHostByNews = [];

        //Массив дополнительных,последующих новостей(по 4) в каждой категории для каждой новости
        //$arrayFourNewsByCategory = [];

        //Массив новостей по категориям сгруперованных по источнику
        $arrayNewsByCategory = [];

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

                $newsByCategory = $valCategories
                    ->news()
                    ->orderBy('news_date', 'desc')
                    ->with('source')
                    ->where(function ($query)  use ($valCategories){
                        return $query->where('source_id', $query->join('categories_news', 'news.id', '=', 'categories_news.news_id')
                            ->where('categories_news.category_id', $valCategories->id)->orderBy('news_date', 'desc')->first()->source_id);
                    })
                    ->take(5)
                    ->get();

                $arrayNewsByCategory[$keyCategories] = $newsByCategory;

                foreach ($newsByCategory as $keyNewsByCategory => $valNewsByCategory) {

                    $hostNews = NewsController::sourceHost($valNewsByCategory);

                    if (!empty($hostNews)) {
                        $arrayHostByNews[$keyCategories][$keyNewsByCategory] = $hostNews;
                    }
                }
            }
        }

        // заголовок страницы
        $title = 'Последние новости';

        return view('news',
            compact('news',
                'sliderNews',
                'monthYearNews',
                'categoriesAll',
                'arrayHostByNews',
                'arrayNewsByCategory',
                'newsByCategory'));
    }

    public function create(Request $request)
    {
        if ($request->user()->can_news()) {
            return view('news.create');
        } else {
            return redirect('/')->whiteErrors('У вас недостаточно прав для написания новости');
        }
    }

    //Получаем новости по выбранной категории
    public function getCategoriesNews($id) {

        //перед выполнение GROUP BY что бы не добавлять ВСЕ неаггрегированные поля выборки, необходимо сбросить sql_mode
        DB::statement("SET SQL_MODE=''");

        //Сгрупированные новости для вывода в боковую панель
        $monthYearNewsWhereSouceId = News::selectRaw('id, year(news_date) year, monthname(news_date) month')
            ->where('source_id', $id)
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->get();

        dd($monthYearNewsWhereSouceId);

        //$monthYearNews = NewsController::newsGroupBy();
        //Получаем для источника сгрупперованные новости по году и месяцу
        //$monthYearNewsWhereSouceId = NewsController::newsGroupByWhereSourceId($sourceId);

        $categoriesNews = Category::find($id)->news()->paginate(5);

        return view('news.category', compact('categoriesNews', 'monthYearNews'));
    }

    //Получаем новости по выбранной группе(месяц и год)
    public function getNewsGroupBy($year, $month) {

        //Получает все новости категории
        $categoriesNews = News::with('source')
            ->selectRaw('*, year(news_date) year, monthname(news_date) month')
            ->having('year', '=', $year)
            ->having('month', '=', $month)
            ->paginate(5);

        $monthYearNews = NewsController::newsGroupBy();

        return view('news.category', compact('categoriesNews', 'monthYearNews'));

    }

    //Получаем данные новости по id
    public function getNews($id) {
        if (!empty($id)) {
            $foundNews = News::with('source')->find($id);

            $sourceId = !empty($foundNews->source_id) ? $foundNews->source_id : 0; //ID источника
            $otherNewsSource = News::with('source')
                ->where('source_id', $sourceId)
                ->orderBy('news_date', 'desc')
                ->take(5)
                ->skip(1)
                ->get();

            //Получаем для источника сгрупперованные новости по году и месяцу
            $monthYearNewsWhereSouceId = NewsController::newsGroupByWhereSourceId($sourceId);

            //Если данные по новость есть то выводим новость, иначе перенаправляем обратно
            if (!empty($foundNews)) {
                //return view('news.one_news', compact('foundNews', 'monthYearNews'));
                return view('news.one_news', compact('foundNews', 'monthYearNewsWhereSouceId', 'otherNewsSource'));
            } else {
                return back();
            }
        } else {
            return back();
        }
    }

}
