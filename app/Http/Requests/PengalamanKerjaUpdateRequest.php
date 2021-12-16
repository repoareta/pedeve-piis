<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PengalamanKerjaUpdateRequest extends FormRequest
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
            'mulai_pengalaman_kerja' => ['required', 'date_format:Y-m-d', Rule::unique('sdm_pengkerja', 'mulai')->ignore($this->pegawai->nopeg, 'nopeg')],            
            'sampai_pengalaman_kerja' => 'required|date_format:Y-m-d|after_or_equal:mulai_pengalaman_kerja',
            'status_pengalaman_kerja' => 'required|string|max:15',
            'instansi_pengalaman_kerja' => 'required|string',
            'pangkat_pengalaman_kerja' => 'required|string',
            'kota_pengalaman_kerja' => 'required|string',
            'negara_pengalaman_kerja' => 'required|string',
        ];
    }
}
