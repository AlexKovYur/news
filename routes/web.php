<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CategoryController;

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

//Категория новости
Route::get('/{id}/category', [NewsController::class, 'getCategoriesNews'])->name('category');

//Новости категории
Route::get('/{id}/news_group_by', [NewsController::class, 'getNewsGroupBy'])->name('news_group_by');

