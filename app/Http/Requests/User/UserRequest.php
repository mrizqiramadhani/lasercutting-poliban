<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use ProtoneMedia\LaravelMixins\Request\ConvertsBase64ToFiles;

class UserRequest extends FormRequest
{
    public $validator;
    use ConvertsBase64ToFiles;

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
        if ($this->isMethod('post')) {
            return $this->store();
        }

        return $this->update();
    }
    public function store(): array
    {
        return [
            'name' => 'required|max:100',
            'email' => 'required|email|unique:m_user',
            'phone_number' => 'required|numeric',
            'photo' => 'nullable|file|image',
            'address' => 'nullable|string',
            'password' => 'required|string',
            'role' => 'required|string'
        ];
    }

    public function update(): array
    {
        return [
            'id' => 'required|exists:m_user,id',
            'name' => 'required|max:100',
            'email' => [
                'required',
                'email',
                Rule::unique('m_user')->ignore(request()->id),
            ],
            'phone_number' => 'required|numeric',
            'photo' => 'nullable|file|image',
            'address' => 'nullable|string',
            'role' => 'required|string'
        ];
    }

    protected function base64FileKeys(): array
    {
        return [
            'photo' => 'foto-product.jpg',
        ];
    }
}
