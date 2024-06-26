<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    public $validator;


    public function failedValidation(Validator $validator)
    {
       $this->validator = $validator;
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|max:100',
            'email' => 'required|email|unique:m_user',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6',
        ];
    }
}
