<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RekeningPekerjaStore extends FormRequest
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
            'nopek' => 'required|unique:pay_tbl_rekening,nopek',
            'kdbank' => 'required',
            'rekening' => 'required|numeric',
            'atasnama' => 'required|string'
        ];
    }
}
