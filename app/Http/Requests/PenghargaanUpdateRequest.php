<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PenghargaanUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tanggal_penghargaan' => ['required', Rule::unique('sdm_penghargaan', 'tanggal')->ignore($this->pegawai->nopeg, 'nopeg')],
            'nama_penghargaan' => 'required|string',
            'pemberi_penghargaan' => 'required|string',
        ];
    }
}
