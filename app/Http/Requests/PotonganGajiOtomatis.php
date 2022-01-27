<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PotonganGajiOtomatis extends FormRequest
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
            'nopek' => ['required'],
            'aard' => ['required'],
            'bulan' => ['required'],
            'tahun' => ['required'],
            'ccl' => ['required'],
            'jmlcc' => ['required'],
            'nilai' => ['required'],
        ];
    }

    public function attributes()
    {
        return [
            'nopek' => 'Pegawai',
            'aard' => 'Potongan',
            'ccl' => 'Mulai cicilan',
            'jmlcc' => 'Jumlah cicilan',
            'nilai' => 'Cicilan/Bulan',
        ];
    }
}
