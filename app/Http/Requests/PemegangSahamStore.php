<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PemegangSahamStore extends FormRequest
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
            'jumlah_lembar_saham_pemegang_saham' => "required|integer|digits_between:0,10",
        ];
    }
}
