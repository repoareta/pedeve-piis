<?php

namespace App\Http\Requests;

use App\Rules\MoneyFormat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PotonganKoreksiGajiUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bulan' => 'required|date_format:n',
            'tahun' => 'required|date_format:Y',
            'userid' => 'required|string',
            'nopek' => [
                'required',
                Rule::unique('pay_koreksigaji')
                    ->where('nopek', $this->nopek)
                    ->where('aard', $this->aard)
                    ->where('bulan', $this->bulan)
                    ->where('tahun', $this->tahun)
                    ->ignore($this->nopek, 'nopek')
            ],
            'aard' => 'required|string',
            'nilai' => ['required', new MoneyFormat, 'max:30'],
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'nopek' => 'Pegawai'
        ];
    }
}
