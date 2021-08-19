<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PembayaranGajiStoreRequest extends FormRequest
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
            'mp' => 'required',
            'bagian' => 'required',
            'nomor' => 'required',
            'bulanbuku' => 'required',
            'jk' => 'required',
            'lokasi' => 'required',
            'ci' => 'required',
            'nobukti' => 'required',
            'kepada' => 'required',
            'tanggal' => 'required',
            'userid' => 'required',
            'kurs' => 'required',
            'nilai' => 'required',
            'ket1' => 'string|nullable',
            'ket2' => 'string|nullable',
            'ket3' => 'string|nullable',
            'nover' => 'required',
        ];
    }

    // public function attributes()
    // {
        
    // }
}
