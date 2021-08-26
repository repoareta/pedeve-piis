<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengalamanKerjaStoreRequest extends FormRequest
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
            'mulai_pengalaman_kerja' => 'required|date_format:Y-m-d',
            'sampai_pengalaman_kerja' => 'required|date_format:Y-m-d',
            'status_pengalaman_kerja' => 'required|string|max:15',
            'instansi_pengalaman_kerja' => 'required|string',
            'pangkat_pengalaman_kerja' => 'required|string',
            'kota_pengalaman_kerja' => 'required|string',
            'negara_pengalaman_kerja' => 'required|string',
        ];
    }
}
