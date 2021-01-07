<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'email|required|unique:users|max:255',   //+проверка, что такого пользователя нет
            'password' => 'required|min:6',
            'vcode' => 'required',
            'name' => 'required|alpha_dash|max:20',      //alpha dash - даёт возможность подчёркивания цифр букв и т.д.
        ];
    }
}
