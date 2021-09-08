<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PerguruanTinggiUpdate extends FormRequest
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
            'kode' => [
                'required',
                'string',
                Rule::unique('sdm_tbl_pt')->ignore($this->perguruan_tinggi, 'kode'),
                'max:4'
            ],
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
