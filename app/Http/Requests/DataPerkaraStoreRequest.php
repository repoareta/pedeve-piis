<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataPerkaraStoreRequest extends FormRequest
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
            'no_perkara' => 'required|string',
            'tgl_perkara' => 'required|date_format:d-m-Y',
            'jenis_perkara' => 'nullable|string',
            'klasifikasi_perkara' => 'nullable|string',
            'status_perkara' => 'nullable|string',
            'r_perkara' => 'nullable|string',
            'r_patitum' => 'nullable|string',
            'r_putusan' => 'nullable|string',
            'nilai_perkara' => 'required|string',
            'ci' => 'nullable|string',
        ];
    }

    /**
     * Attributes.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'no_perkara' => 'Nomor Perkara',
            'tgl_perkara' => 'Tanggal Perkara',
            'r_perkara' => 'Ringkasan Perkara',
            'r_petitium' => 'Ringkasan Petitium',
            'r_putusan' => 'Ringkasan Putusan',
        ];
    }
}
