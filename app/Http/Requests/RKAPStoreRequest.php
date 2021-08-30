<?php

namespace App\Http\Requests;

use App\Rules\MoneyFormat;
use Illuminate\Foundation\Http\FormRequest;

class RKAPStoreRequest extends FormRequest
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
            'aset' => ['required', new MoneyFormat, 'max:18'],
            'pendapatan_usaha' => ['required', new MoneyFormat, 'max:18'],
            'beban_usaha' => ['required', new MoneyFormat, 'max:18'],
            'pendapatan_beban_lain' => ['required', new MoneyFormat, 'max:18'],
            'laba_bersih' => ['required', new MoneyFormat, 'max:18'],
            'ebitda' => ['required', new MoneyFormat, 'max:18'],
            'investasi_bd' => ['required', new MoneyFormat, 'max:18'],
            'investasi_nbd' => ['required', new MoneyFormat, 'max:18'],
            'tkp' => ['required', new MoneyFormat, 'max:18'],
            'kpi' => ['required', new MoneyFormat, 'max:18']
        ];
    }
}
