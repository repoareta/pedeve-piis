<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgamaStore extends FormRequest
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
            'kode' => ['required', 'string', 'unique:sdm_tbl_agama,kode', 'max:2'],
            'nama' => ['required', 'string'],
        ];
    }

    public function attributes()
    {
        return [
            'kode' => 'Kode Agama',
            'nama' => 'Nama Agama',
        ];
    }
}
