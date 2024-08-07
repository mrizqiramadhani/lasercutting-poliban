<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use ProtoneMedia\LaravelMixins\Request\ConvertsBase64ToFiles;
use Illuminate\Support\Facades\Log;
class TransactionRequest extends FormRequest
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
        // Log::debug('Request data:', $this->all());
        return [
            'status_order' => 'required|in:waiting,order_place,on_progress,out_of_delivery,finished|max:100',
            'photo_receipt' => 'required|file|image',
            'cart.*.id' => 'required|exists:m_cart,id',
            'cart.*.stock' => 'required|numeric'
        ];
    }

    public function update(): array
    {
        return [
            'id' => 'required|exists:m_transaction,id',
            'status_order' => 'required|in:waiting,order_place,on_progress,out_of_delivery,finished|max:100',
        ];
    }

    protected function base64FileKeys(): array
    {
        return [
            'photo_receipt' => 'foto-receipt.jpg',
        ];
    }
}
