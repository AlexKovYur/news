<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostFormRequest extends FormRequest
{
    /**
    * Определите, имеет ли пользователь право делать этот запрос.
    *
    * @return bool
    */
    public function authorize()
    {
        if ($this->user()->can_post()) {
            return true;
        }
        return false;
    }
    /**
    * Получите правила проверки, применимые к запросу.
    *
    * @return array
    */
    public function rules()
    {
        return [
            'title' => 'required|unique:news|max:255',
            'title' => array('Regex:/^[A-Za-z0-9 ]+$/'),
            'body' => 'required',
        ];
    }


}
