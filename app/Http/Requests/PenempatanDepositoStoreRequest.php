<?php

namespace App\Http\Requests;

use App\Rules\MoneyFormat;
use Illuminate\Foundation\Http\FormRequest;

class PenempatanDepositoStoreRequest extends FormRequest
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
            'nodok' => 'required|string',
            'namabank' => 'required',
            'nominal' => ['nullable'],
            'tanggal' => 'required|date_format:d-m-Y',
            'tanggal2' => 'required|date_format:d-m-Y',
            'noseri' => 'required|string',
            'lineno' => 'required',
            'asal' => 'nullable',
            'kdbank' => 'required',
            'tahunbunga' => 'required',
            'perpanjangan' => 'required',
            'keterangan' => 'required',
            'kurs' => 'required',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'nodok' => 'Nomor Dokumen',
            'namabank' => 'Nama Bank',
            'nominal' => 'Nominal',
            'tanggal' => 'Tanggal',
            'tanggal2' => 'Jatuh Tempo',
            'tahunbunga' => 'Bunga',
            'noseri' => 'Nomor Seri',
        ];
    }
}
