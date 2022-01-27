<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProsesGajiRequest extends FormRequest
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
            'prosesupah' => ['required'],
            'tanggalupah' => ['required'],
            'radioupah' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'radioupah.required' => 'Silahkan pilih proses atau batal',
        ];
    }

    public function attributes()
    {
        return [
            'tanggalupah' => 'Bulan/Tahun',
        ];
    }
}
