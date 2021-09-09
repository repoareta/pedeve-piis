<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KodeBagianUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'kode' => [
                'required',
                'string',
                Rule::unique('sdm_tbl_kdbag')->ignore($this->kode_bagian, 'kode'),
                'max:6'
            ],
            'nama' => ['required', 'string'],
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
