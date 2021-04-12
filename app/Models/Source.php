<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;

    protected $table = 'sources';
    //ограничивает изменение столбцов
    protected $guarded = [];

    //у источника много новостей
    public function source()
    {
        return $this->hasMany(News::class, 'source_id');
    }
}
