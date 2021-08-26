<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeminarStoreRequest extends FormRequest
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
            'mulai_seminar' => 'required|date_format:Y-m-d',
            'sampai_seminar' => 'required|date_format:Y-m-d',
            'nama_seminar' => 'required|string',
            'penyelenggara_seminar' => 'required|string',
            'kota_seminar' => 'required|string',
            'negara_seminar' => 'required|string',
            'keterangan_seminar' => 'nullable|string',
        ];
    }
}
