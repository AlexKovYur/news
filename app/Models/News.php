<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';
    // ограничивает изменение столбцов
    protected $guarded = [];

    //Поле даты
    protected $dates = ['news_date'];


    // возвращает экземпляр пользователя, который является автором этого сообщения
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function categories() {
        return $this->belongsToMany(Category::class, 'categories_news', 'news_id', 'category_id' );
    }
}
