<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SMKStoreRequest extends FormRequest
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
            'tahun_smk' => 'required|date_format:Y|unique:sdm_smk,tahun',
            'nilai_smk' => 'required|numeric|digits:1',
        ];
    }
}
