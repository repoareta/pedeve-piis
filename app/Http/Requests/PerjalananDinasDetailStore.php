<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerjalananDinasDetailStore extends FormRequest
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
            'no_urut'    => 'required|numeric',
            'keterangan' => 'required',
            'nopek'      => 'required',
            'jabatan'    => 'required',
            'golongan'   => 'required',
        ];
    }
}
