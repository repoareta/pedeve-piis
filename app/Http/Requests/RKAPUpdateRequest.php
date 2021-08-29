<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RKAPUpdateRequest extends FormRequest
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
            'nama' => 'required|string',
            'ci' => 'required|string',
            'tahun' => 'required|date_format:Y',
            'bulan' => 'nullable|date_format:m',
            'kurs' => 'nullable',
            'aset' => 'required',
            'pendapatan_usaha' => 'required',
            'beban_usaha' => 'required',
            'pendapatan_beban_lain' => 'required',
            'laba_bersih' => 'required',
            'ebitda' => 'required',
            'investasi_bd' => 'required',
            'investasi_nbd' => 'required',
            'tkp' => 'required',
            'kpi' => 'required',
        ];
    }
}
