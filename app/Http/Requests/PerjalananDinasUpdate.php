<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerjalananDinasUpdate extends FormRequest
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
            'no_spd'      => 'required',
            'tanggal'     => 'required',
            'nopek'       => 'required',
            'jabatan'     => 'required',
            'golongan'    => 'required',
            'ktp'         => 'required',
            'jenis_dinas' => 'required',
            'dari'        => 'required',
            'tujuan'      => 'required',
            'mulai'       => 'required',
            'sampai'      => 'required',
            'kendaraan'   => 'required',
            'biaya'       => 'required',
            'keterangan'  => 'required',
            'jumlah'      => 'required',
        ];
    }
}
