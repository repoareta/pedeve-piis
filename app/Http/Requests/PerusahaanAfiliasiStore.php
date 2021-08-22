<?php

namespace App\Http\Requests;

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
            'no_telepon' => 'string|digits_between:6,15',
            'bidang_usaha' => 'required',
            'npwp' => 'string',
            'modal_dasar' => 'required|string',
            'modal_disetor' => 'required|string',
            'jumlah_lembar_saham' => 'required|integer',
            'nilai_nominal_per_saham' => 'required|string',
        ];
    }
}
