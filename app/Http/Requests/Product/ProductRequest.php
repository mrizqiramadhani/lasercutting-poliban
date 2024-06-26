<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use ProtoneMedia\LaravelMixins\Request\ConvertsBase64ToFiles;

class ProductRequest extends FormRequest
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
            'photo' => 'nullable|file|image',
            'description' => 'required|max:255',
            'stock' => 'required|numeric    '
        ];
    }

    public function update(): array
    {
        return [
            'id' => 'required|exists:m_products,id',
            'name' => 'required|max:100',
            'photo' => 'nullable|file|image',
            'description' => 'required|max:255',
            'stock' => 'required|numeric',
            'price' => 'required|numeric'
        ];
    }

    protected function base64FileKeys(): array
    {
        return [
            'photo' => 'foto-product.jpg',
        ];
    }
}
