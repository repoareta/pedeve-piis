<?php

namespace App\Http\Requests;

use App\Rules\MoneyFormat;
use Illuminate\Foundation\Http\FormRequest;

class UMKDetailStoreRequest extends FormRequest
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
            'keterangan' => 'nullable',
            'acc' => 'required',
            'nilai' => ['required', new MoneyFormat, 'max:30'],
            'cj' => 'required',
            'jb' => 'required',
            'bagian' => 'required',
            'pk' => 'required|numeric',
            'no_umk' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'acc' => 'Account',
            'cj' => 'Cash Judex',
            'jb' => 'Jenis Biaya',
            'bagian' => 'Kode Bagian',
            'pk' => 'Perintah Kerja',
        ];
    }
}
