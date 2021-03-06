<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KomisarisStore extends FormRequest
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
            'nama' => 'required|string',
            'tmt_dinas' => 'required|date_format:Y-m-d',
            'akhir_masa_dinas' => 'required|date_format:Y-m-d|after_or_equal:tmt_dinas',
        ];
    }
}
