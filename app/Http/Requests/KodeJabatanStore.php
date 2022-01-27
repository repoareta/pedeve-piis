<?php

namespace App\Http\Requests;

use App\Rules\MoneyFormat;
use Illuminate\Foundation\Http\FormRequest;

class KodeJabatanStore extends FormRequest
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
            'kode_bagian' => ['required', 'string'],
            'kdjab' => ['required', 'string', 'unique:sdm_tbl_kdjab,kdjab', 'max:5'],
            'nama' => ['required', 'string', 'max:50'],
            'golongan' => ['required', 'string', 'max:3'],
            'tunjangan' => ['required', new MoneyFormat, 'max:30'],
        ];
    }
}
