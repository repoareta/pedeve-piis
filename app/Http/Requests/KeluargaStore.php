<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KeluargaStore extends FormRequest
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
            'status' => ['required'],
            'nama' => ['required', 'string', 'unique:sdm_keluarga,nama'],
            'tempat_lahir' => ['required', 'string'],
            'tanggal_lahir' => ['required'],
            'agama' => ['required'],
            'golongan_darah' => ['required'],
            'pendidikan' => ['required'],
            'tempat_pendidikan' => ['required'],
            'photo' => ['nullable', 'file'],
        ];
    }
}
