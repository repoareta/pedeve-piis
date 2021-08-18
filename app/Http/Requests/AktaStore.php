<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AktaStore extends FormRequest
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
            'perusahaan_afiliasi_id' => 'required|string',
            'jenis_akta' => 'required|string',
            'nomor_akta' => 'required|string',
            'tanggal_akta' => 'required|date_format:d-m-Y',
            'notaris' => 'required|string',
            'tmt_berlaku' => 'required|date_format:d-m-Y',
            'tmt_berakhir' => 'required|date_format:d-m-Y',
            'created_by' => 'required|string',
            'dokumen_akta' => 'required|file',
        ];
    }
}
