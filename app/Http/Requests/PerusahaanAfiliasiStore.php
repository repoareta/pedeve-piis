<?php

namespace App\Http\Requests;

use App\Rules\MoneyFormat;
use Illuminate\Foundation\Http\FormRequest;

class PerusahaanAfiliasiStore extends FormRequest
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
            'nama_perusahaan' => 'required|unique:cm_perusahaan_afiliasi,nama',
            'alamat' => 'required',
            'no_telepon' => 'required|numeric|digits_between:6,15',
            'bidang_usaha' => 'required|string',
            'npwp' => 'required|string',
            'modal_dasar' => ['required', new MoneyFormat, 'max:30'],
            'modal_disetor' => ['required', new MoneyFormat, 'max:30'],
            'jumlah_lembar_saham' => ['required', new MoneyFormat, 'max:30'],
            'nilai_nominal_per_saham' => ['required', new MoneyFormat, 'max:30'],
        ];
    }
}
