<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddContact extends ApiAddContactRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "name" => "string|unique:user_contacts,name|max:50",
            "user_id" => "integer",
            "date_of_birth" => "nullable|date_format:Y-m-d|max:15",
            "phone_contact" => "nullable|string|max:50",
            "email_contact" => "nullable|string|max:50",
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'Поле name не должно быть пустым',
            'name.unique' => 'Поле name должно быть уникальным',
            'name.max' => 'Поле name должно быть не больше 50 символов',
            'date_of_birth.date_format' => 'Поле date_of_birth должно быть в формате 2023-02-02',
        ];
    }
}
