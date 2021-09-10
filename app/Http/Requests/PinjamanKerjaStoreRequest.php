<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MoneyFormat;
class PinjamanKerjaStoreRequest extends FormRequest
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
            'id_pinjaman' => 'required',
            'nopek' => 'required',
            'jml_pinjaman' => ['required', new MoneyFormat, 'max:14'],
            'tenor' => 'required|numeric|digits_between:1,3',
            'mulai' => 'required|date_format:d-m-Y',
            'sampai' => 'required|date_format:d-m-Y',
            'angsuran' => ['required', new MoneyFormat, 'max:14'],
            'no_kontrak' => 'required|string',
        ];
    }

    /**
     * attributes
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'jml_pinjaman' => 'Jumlah Pinjaman'
        ];
    }
}
