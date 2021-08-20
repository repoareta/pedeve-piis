<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetailKuasaHukumStoreRequest extends FormRequest
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
            'cekhakim' => 'nullable',
            'kd_hakim' => 'required',
            'kd_pihak' => 'required',
            'no_perkara' => 'required',
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'telp' => 'required|numeric|digits_between:6,15',
            'keterangan' => 'nullable|string',
            'status' => 'required|string',
        ];
    }

    public function attributes()
    {
        return [
            'kd_pihak' => 'Pihak',
            'no_perkara' => 'Nomor Perkara',
        ];
    }
}
