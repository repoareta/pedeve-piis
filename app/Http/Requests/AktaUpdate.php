<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AktaUpdate extends FormRequest
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
            'tanggal_akta' => 'required|date_format:Y-m-d',
            'notaris' => 'required|string',
            'tmt_berlaku' => 'required|date_format:Y-m-d',
            'tmt_berakhir' => 'required|date_format:Y-m-d|after_or_equal:tmt_berlaku',
            'created_by' => 'required|string',
            'dokumen_akta' => 'nullable|file',
        ];
    }
}
