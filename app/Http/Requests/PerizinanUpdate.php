<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerizinanUpdate extends FormRequest
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
            'perusahaan_afiliasi_id' => 'required',
            'keterangan' => 'required|string',
            'nomor' => 'required|numeric',
            'masa_berlaku_akhir' => 'required|date_format:Y-m-d',
            'created_by' => 'required|string',
            'filedok.*' => 'required|mimes:pdf|max:100000',
        ];
    }

    public function attributes()
    {
        return [
            'filedok.*' => 'Dokumen Perizinan'
        ];
    }
}
