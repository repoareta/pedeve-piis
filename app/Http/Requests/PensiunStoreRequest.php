<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PensiunStoreRequest extends FormRequest
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
            'pribadi' => 'required|numeric',
            'perusahaan' => 'required|numeric',
            'perusahaan2' => 'required|numeric',
            'perusahaan3' => 'required|numeric',
        ];
    }

    /**
     * attributes
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'perusahaan' => 'Perusahaan Direksi',
            'perusahaan2' => 'Perusahaan Pekerja',
            'perusahaan3' => 'Perusahaan Direksi (BNI)',
        ];
    }
}
