<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermintaanBayarStoreRequest extends FormRequest
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
            'nobayar' => 'required',
            'tanggal' => 'required|date_format:d-m-Y',
            'lampiran' => 'required',
            'keterangan' => 'required',
            'dibayar' => 'required',
            'debetdari' => 'required',
            'rekyes' => 'nullable',
            'nodebet' => 'required',
            'tgldebet' => 'required|date_format:d-m-Y',
            'nokas' => 'nullable',
            'bulanbuku' => 'required',
            'ci' => 'required',
            'kurs' => 'required',
            'mulai' => 'required|date_format:d-m-Y',
            'sampai' => 'required|date_format:d-m-Y',
        ];
    }
}
