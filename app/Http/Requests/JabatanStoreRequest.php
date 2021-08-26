<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JabatanStoreRequest extends FormRequest
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
            'nopeg' => 'required',
            'bagian' => 'required',
            'jabatan' => 'required',
            'mulai' => 'required|unique:sdm_jabatan,mulai',
            'sampai' => 'required',
            'no_skep' => 'nullable',
            'tanggal_skep' => 'nullable',
        ];
    }

    public function attributes()
    {
        return [
            'no_skep' => 'No SKEP',
            'tanggal_skep' => 'Tanggal SKEP',
            'mulai' => 'Tanggal Mulai',
            'sampai' => 'Tanggal Sampai',
        ];
    }
}
