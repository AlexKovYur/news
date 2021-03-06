<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CategoryController;

use App\Http\Controllers\TestParsingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [NewsController::class, 'index'])->name('news');

Route::get('/new-news', [NewsController::class, 'create'])->name('create_new_news');

//Добавление категорий новостей
Route::get('/add-category', [CategoryController::class, 'addCategories'])->name('add_category');

//Удаление всех данных таблицы категории
Route::get('delete-all-categories', [CategoryController::class, 'deleteAllCategories'])->name('delete_all_categories');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Получаем новость по выбранной категории
Route::get('/category/{id}', [NewsController::class, 'getCategoriesNews'])->name('category');

//Получаем новости по выбранной группе(месяц и год)
Route::get('/arhive/{year}/{month}', [NewsController::class, 'getNewsGroupBy'])->name('arhive');

//Получаем выбранную новость
Route::get('/news/{id}', [NewsController::class, 'getNews'])->name('one_news');

//Тест пасинга
Route::get('/test-parsing', [TestParsingController::class, 'test'])->name('test_parsing');

