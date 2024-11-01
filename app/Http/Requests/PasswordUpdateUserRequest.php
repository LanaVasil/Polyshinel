<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordUpdateUserRequest extends FormRequest
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
        return [
          'token' => 'required',
          'email' => ['required','email'],
          'password' => ['required', 'string', 'min:3','confirmed'],
        ];
    }

    public function attributes()
    {
        return [
          'token' => 'Маркер',
          'email' => 'Електрона пошта',
          'password' => 'Пароль'
        ];
    }
}