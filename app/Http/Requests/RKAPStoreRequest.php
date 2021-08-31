<?php

namespace App\Http\Requests;

use App\Rules\MoneyFormat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'kategori' => 'required',
            'nama' => 'required|string',
            'ci' => 'required|string',
            'tahun' => 'required|date_format:Y',
            'bulan' => [
                'sometimes',
                'required_if:kategori,realisasi',
                Rule::unique('tbl_rencana_kerja', 'bulan')
                ->where(function ($query) {
                    $query->where('kd_perusahaan', $this->request->get('nama'))
                    ->where('tahun', $this->request->get('tahun'))
                    ->where('bulan', $this->request->get('bulan'));
                })
            ],
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
