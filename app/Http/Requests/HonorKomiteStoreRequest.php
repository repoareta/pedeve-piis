<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HonorKomiteStoreRequest extends FormRequest
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
            'bulan' => 'required|date_format:n',
            'tahun' => 'required|date_format:Y',
            'userid' => 'required|string',
            'nopek' => [
                'required',
                Rule::unique('pay_honorarium')
                    ->where('nopek', $this->nopek)
                    ->where('bulan', $this->bulan)
                    ->where('tahun', $this->tahun)
            ],
            'nilai' => 'required|numeric',
        ];
    }
}
