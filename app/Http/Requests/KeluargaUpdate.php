<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KeluargaUpdate extends FormRequest
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
            'status_keluarga' => ['required'],
            'nama_keluarga' => ['required', 'string'],
            'tempat_lahir_keluarga' => ['required', 'string'],
            'tanggal_lahir_keluarga' => ['required'],
            'agama_keluarga' => ['required'],
            'golongan_darah_keluarga' => ['required'],
            'pendidikan_keluarga' => ['required'],
            'tempat_pendidikan_keluarga' => ['required'],
            'photo_keluarga' => ['nullable', 'file'],
        ];
    }
}
