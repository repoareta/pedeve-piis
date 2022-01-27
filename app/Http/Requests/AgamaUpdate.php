<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AgamaUpdate extends FormRequest
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
                Rule::unique('sdm_tbl_agama')->ignore($this->agama, 'kode'),
                'max:2'
            ],
            'nama' => ['required', 'string', 'max:50'],
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
