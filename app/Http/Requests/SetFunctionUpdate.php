<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetFunctionUpdate extends FormRequest
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
            'userid'      => 'required',
            'menuid'      => 'required|numeric',
            'tambah'      => 'nullable',
            'ubah'        => 'nullable',
            'hapus'       => 'nullable',
            'cetak'       => 'nullable',
            'lihat'       => 'nullable',
        ];
    }
}
