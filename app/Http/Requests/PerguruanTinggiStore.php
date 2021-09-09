<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerguruanTinggiStore extends FormRequest
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
            'kode' => ['required', 'string', 'unique:sdm_tbl_pt,kode', 'max:4'],
            'nama' => ['required', 'string'],
        ];
    }

    public function attributes()
    {
        return [
            'kode' => 'Kode perguruan tinggi',
            'nama' => 'Nama perguruan tinggi',
        ];
    }
}
