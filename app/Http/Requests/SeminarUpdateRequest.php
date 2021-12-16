<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class SeminarUpdateRequest extends FormRequest
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
            'mulai_seminar' => ['required', 'date_format:Y-m-d', Rule::unique('sdm_seminar', 'mulai')->ignore($this->pegawai->nopeg, 'nopeg')],
            'sampai_seminar' => 'required|date_format:Y-m-d|after_or_equal:mulai_seminar',
            'nama_seminar' => 'required|string',
            'penyelenggara_seminar' => 'required|string',
            'kota_seminar' => 'required|string',
            'negara_seminar' => 'required|string',
            'keterangan_seminar' => 'nullable|string',
        ];
    }
}
