<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MasterBankStoreRequest extends FormRequest
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
            'kode' => 'required|string|max:2|unique:pay_tbl_bank,kode',
            'nama' => 'required|string|max:50',
            'alamat' => 'required|string',
            'kota' => 'required|string|max:50',
        ];
    }
}
