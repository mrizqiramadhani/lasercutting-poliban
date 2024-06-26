<?php

namespace App\Http\Requests\Role;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
        if ($this->isMethod('post')) {
            return $this->store();
        }

        return $this->update();

    }
    public function store():array
    {
        return [
            'name' => 'required|max:100'
        ];
    }

    public function update():array {
        return [
            'id' => 'required|exists:m_role,id',
            'name' => 'required|max:100',
        ];
    }

}
