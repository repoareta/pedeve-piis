<?php

namespace App\Http\Requests;

use App\Rules\MoneyFormat;
use Illuminate\Foundation\Http\FormRequest;

class PUMKDetailStoreRequest extends FormRequest
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
            'no_urut' => 'required',
            'keterangan' => 'nullable',
            'account' => 'required',
            'nilai' => ['required', new MoneyFormat, 'max:30'],
            'cj' => 'required',
            'jb' => 'required',
            'bagian' => 'required',
            'pk' => 'required|numeric',
            'no_pumk' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'cj' => 'Cash Judex',
            'jb' => 'Jenis Biaya',
            'bagian' => 'Kode Bagian',
            'pk' => 'Perintah Kerja',
        ];
    }
}
