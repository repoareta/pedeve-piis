<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KodeBagianStore extends FormRequest
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
            'kode' => ['required', 'string', 'unique:sdm_tbl_kdbag,kode', 'max:6'],
            'nama' => ['required', 'string', 'max:50'],
        ];
    }

    public function attributes()
    {
        return [
            'kode' => 'Kode bagian',
            'nama' => 'Nama bagian',
        ];
    }
}
