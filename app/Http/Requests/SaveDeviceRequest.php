<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveDeviceRequest extends FormRequest
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
          'name' => ['required', 'string', 'min:3', 'max:255'],
          'brand_id' => ['required'],
          'devtype_id' => ['required'],
          'status' => ['required']
          // 'status' => ['nullable', 'tinyInteger']
        ];
    }

    public function attributes()
    {
        return [
          'name' => 'Назва',
          'brand_id' => 'Бренд',
          'devtype_id' => 'Види пристроїв',
          'status' => ['Статус']
        ];
    }
}
