<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
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
            'product_id' => 'required|exists:m_products,id',
            'user_id' => 'required|exists:m_user,id',
        ];
    }
}
