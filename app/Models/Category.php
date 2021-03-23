<?php

namespace App\Models;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $guarded = [];

    public function news() {
        return $this->belongsToMany(News::class, 'categories_news', 'category_id', 'news_id');
    }

    public function twoNews()
    {
        return $this
            ->belongsToMany(News::class, 'categories_news', 'category_id', 'news_id')
            ->orderBy('news_date', 'desc')
            ->limit(2);
    }

    public function fourNewsSkipTwo()
    {
        return $this
            ->belongsToMany(News::class, 'categories_news', 'category_id', 'news_id')
            ->orderBy('news_date', 'desc')
            ->limit(4)
            ->skip(2);
    }
}
