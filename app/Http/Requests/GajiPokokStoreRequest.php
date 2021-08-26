<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GajiPokokStoreRequest extends FormRequest
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
            'mulai_gaji_pokok' => 'required',
            'sampai_gaji_pokok' => 'required',
            'nilai_gaji_pokok' => 'required',
            'keterangan_gaji_pokok' => 'nullable',
        ];
    }
}
