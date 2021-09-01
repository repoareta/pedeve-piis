<?php

namespace App\Http\Requests;

use App\Rules\MoneyFormat;
use Illuminate\Foundation\Http\FormRequest;

class PemegangSahamUpdate extends FormRequest
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
            'nama_pemegang_saham'   => "required",
            'kepemilikan'    => "required|numeric|min:0|max:100",
            'jumlah_lembar_saham_pemegang_saham' => ['required', new MoneyFormat, 'max:18'],
        ];
    }
}
