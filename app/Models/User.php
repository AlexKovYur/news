<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\News;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ROLE_ADMIN = 'admin';
    const ROLE_AUTHOR = 'author';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // у пользователя много новостей
    public function news()
    {
        return $this->hasMany(News::class, 'author_id');
    }

    // проверяет, может ли пользователь опубликовать статью или нет
    public function can_news()
    {
        $role = $this->role;
        if ($role == self::ROLE_AUTHOR || $role == self::ROLE_ADMIN) {
            return true;
        }
        return false;
    }

    //проверяет, является ли роль администратором
    public function is_admin()
    {
        $role = $this->role;
        if ($role == self::ROLE_ADMIN) {
            return true;
        }
        return false;
    }
}
