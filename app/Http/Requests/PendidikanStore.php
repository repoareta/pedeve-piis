<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PendidikanStore extends FormRequest
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
            'mulai_pendidikan_pegawai' => 'required|date_format:Y-m-d',
            'sampai_pendidikan_pegawai' => 'required|date_format:Y-m-d',
            'kode_pendidikan_pegawai' => 'required',
            'tempat_didik_pegawai' => 'required',
            'kode_pt_pendidikan_pegawai' => 'required',
            'catatan_pendidikan_pegawai' => 'nullable',
        ];
    }
}
