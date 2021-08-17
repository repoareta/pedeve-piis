<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UMKStoreRequest extends FormRequest
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
            'no_umk' => 'required|string',
            'tgl_panjar' => 'required|date_format:d-m-Y',
            'kepada' => 'required|string',
            'jenis_um' => 'required',
            'bulan_buku' => 'required',
            'ci' => 'required',
            'rate' => 'required',
            'keterangan' => 'required',
            'jumlah' => 'required',
        ];
    }
}
