<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'birthday' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O Campo name e obrigatorio',
            'email.required' => 'O Campo email e obrigatorio',
            'email.email' => 'E-mail invalido',
            'email.unique' => 'E-mail ja utilizado',
            'birthday.required' => 'Bithday e obrigatorio',
        ];
    }
}
