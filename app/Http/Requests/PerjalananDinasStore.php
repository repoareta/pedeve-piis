<?php

namespace App\Http\Requests;

use Elegant\Sanitizer\Laravel\SanitizesInput;
use Illuminate\Foundation\Http\FormRequest;

class PerjalananDinasStore extends FormRequest
{
    use SanitizesInput;

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
            'no_spd'      => 'required|unique:App\Models\PanjarHeader,no_panjar',
            'tanggal'     => 'required|date',
            'nopek'       => 'required',
            'jabatan'     => 'required',
            'golongan'    => 'required',
            'ktp'         => 'required',
            'jenis_dinas' => 'required',
            'dari'        => 'required',
            'tujuan'      => 'required',
            'mulai'       => 'required|date',
            'sampai'      => 'required|date',
            'kendaraan'   => 'required',
            'biaya'       => 'required',
            'keterangan'  => 'required',
            'jumlah'      => 'required',
        ];
    }
    
    /**
     *  Filters to be applied to the input.
     *
     * @return array
     */
    public function filters()
    {
        return [
            'jumlah' => 'trim',
        ];
    }
}
