<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermintaanBayarDetailStoreRequest extends FormRequest
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
            'no' => 'required',
            'keterangan' => 'required',
            'acc' => 'required',
            'nilai' => 'required',
            'cj' => 'required',
            'jb' => 'required',
            'bagian' => 'required',
            'pk' => 'required',
            'nobayar' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'acc' => 'Account',
            'cj' => 'Cash Judex',
            'jb' => 'Jenis Biaya',
            'pk' => 'Perintah Kerja',
        ];
    }
}
