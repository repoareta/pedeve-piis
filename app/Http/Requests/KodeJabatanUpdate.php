<?php

namespace App\Http\Requests;

use App\Rules\MoneyFormat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KodeJabatanUpdate extends FormRequest
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
            'kode_bagian' => ['required', 'string'],
            'kdjab' => ['required', 'string', Rule::unique('sdm_tbl_kdjab')->ignore($this->kdjab, 'kdjab'), 'max:5'],
            'nama' => ['required', 'string'],
            'golongan' => ['required', 'string'],
            'tunjangan' => ['required', new MoneyFormat, 'max:30'],
        ];
    }
}
