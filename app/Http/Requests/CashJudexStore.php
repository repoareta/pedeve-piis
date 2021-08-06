<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CashJudexStore extends FormRequest
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
            'kode' => 'unique:App\Models\CashJudex,kode|required|integer',
            'nama' => 'required|string',
        ];
    }
}
