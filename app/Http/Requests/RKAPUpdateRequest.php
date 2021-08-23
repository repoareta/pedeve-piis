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
            'kurs' => 'date_format:m',
            'aset' => 'required|numeric',
            'pendapatan_usaha' => 'required|numeric',
            'beban_usaha' => 'required|numeric',
            'pendapatan_beban_lain' => 'required|numeric',
            'laba_bersih' => 'required|numeric',
            'ebitda' => 'required|numeric',
            'investasi_bd' => 'required|numeric',
            'investasi_nbd' => 'required|numeric',
            'tkp' => 'required|numeric',
            'kpi' => 'required|numeric',
        ];
    }
}
