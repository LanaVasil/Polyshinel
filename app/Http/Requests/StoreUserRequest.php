<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;
        return true;
    }

    public function rules()
    {
      // ['nullable', 'string', 'email'] - коли наявність поля зі значенням не обов'зкове
        return [
          'name' => ['required', 'string', 'max:255'],
          'login' => ['required', 'string', 'min:3', 'max:255', 'unique:users'],
          'email' => ['required', 'string','email', 'max:255', 'unique:users'],
          'password' => ['required', 'string', 'min:3', 'confirmed']
        ];
    }

    public function attributes()
    {
        return [
          'name' => 'Прізвище та ініціали',
          'login' => 'Логін',
          'email' => 'Електрона пошта',
          'password' => 'Пароль'
        ];
    }
}
