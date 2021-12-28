<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorStore extends FormRequest
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
            'nama'        => 'required',
            'alamat'      => 'required',
            'telepon'     => 'required|numeric',
            'no_rekening' => 'nullable|numeric',
            'atas_nama'   => 'required',
            'nama_bank'   => 'required',
            'cabang_bank' => 'required',
        ];
    }
}
