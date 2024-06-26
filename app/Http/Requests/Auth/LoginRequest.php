<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email|exists:m_user,email',
            'password' => 'required|min:6',
        ];
    }
}
