<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KursusUpdate extends FormRequest
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
            'mulai_kursus' => 'required',
            'sampai_kursus' => 'required',
            'nama_kursus' => 'required',
            'penyelenggara_kursus' => 'required',
            'kota_kursus' => 'required',
            'negara_kursus' => 'required',
            'keterangan_kursus' => 'nullable',
        ];
    }
}
