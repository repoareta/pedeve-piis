<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GcgSosialisasiStore extends FormRequest
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
            'keterangan' => 'required|string',
            'dokumen.*' => 'required|mimes:pdf,jpg,jpeg,png',
        ];
    }
}
