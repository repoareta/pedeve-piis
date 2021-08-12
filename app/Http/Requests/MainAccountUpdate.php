<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainAccountUpdate extends FormRequest
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
            'jenis' => 'required|string',
            'batas_awal' => 'required|numeric',
            'batas_akhir' => 'required|numeric',
            'urutan' => 'required|string',
            'pengali' => 'required|numeric',
            'pengali_tampil' => 'required|numeric',
            'sub_akun' => 'required|numeric',
            'lokasi' => 'required|string'
        ];
    }
}
