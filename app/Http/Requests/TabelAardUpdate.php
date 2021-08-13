<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TabelAardUpdate extends FormRequest
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
            'kode' => 'required|numeric',
            'nama' => 'required|string',
            'jenis' => 'required|numeric',
            'kenapajak' => 'required|string|in:Y,N',
            'lappajak' => 'required|string|in:Y,N',
        ];
    }
}
