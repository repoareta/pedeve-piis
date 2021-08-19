<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PUMKStoreRequest extends FormRequest
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
            'no_pumk' => 'required|string|unique:pumk_header,no_pumk',
            'tanggal' => 'required|date_format:Y-m-d',
            'no_umk' => 'required|string',
            'nopek' => 'required|string',
            'jabatan' => 'required|string',
            'golongan' => 'required|string',
            'keterangan' => 'required|string',
            'jumlah' => 'required|string',
            'jumlah_detail_pumk' => 'required|string',
        ];
    }
}
