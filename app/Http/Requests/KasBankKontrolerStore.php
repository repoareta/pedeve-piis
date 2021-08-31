<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KasBankKontrolerStore extends FormRequest
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
            'kodestore' => 'required|numeric|unique:storejk',
            'jeniskartu' => 'required|numeric|in:10,11,13', 
            'kodeacct' => 'required|numeric|exists:account',
            'ci' => 'required|numeric|in:1,2',
            'namabank' => 'required|string',
            'norekening' => 'required|numeric',
            'lokasi' => 'required|string|in:MD,MS'
        ];
    }
}
