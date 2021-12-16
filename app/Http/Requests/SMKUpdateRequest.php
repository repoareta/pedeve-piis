<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class SMKUpdateRequest extends FormRequest
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
            'tahun_smk' => ['required', 'date_format:Y', Rule::unique('sdm_smk', 'tahun')->ignore($this->pegawai->nopeg, 'nopeg')],
            'nilai_smk' => 'required|numeric|digits:1',
        ];
    }
}
