<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PembayaranUMKStoreRequest extends FormRequest
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
            'ket1' => 'nullable',
            'ket2' => 'nullable',
            'ket3' => 'nullable',
            'nover' => 'required',
        ];
    }
}
