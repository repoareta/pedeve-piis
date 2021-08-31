<?php

namespace App\Http\Requests;

use App\Rules\MoneyFormat;
use Illuminate\Foundation\Http\FormRequest;

class PerusahaanAfiliasiUpdate extends FormRequest
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
            'nama_perusahaan' => 'required|string',
            'alamat' => 'required',
            'no_telepon' => 'required|numeric|digits_between:6,15',
            'bidang_usaha' => 'required|string',
            'npwp' => 'required|string',
            'modal_dasar' => ['required', new MoneyFormat, 'max:18'],
            'modal_disetor' => ['required', new MoneyFormat, 'max:18'],
            'jumlah_lembar_saham' => ['required', new MoneyFormat, 'digits_between:0,13'],
            'nilai_nominal_per_saham' => ['required', new MoneyFormat, 'max:18'],
        ];
    }
}
