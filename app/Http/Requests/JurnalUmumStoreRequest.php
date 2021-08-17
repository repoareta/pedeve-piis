<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JurnalUmumStoreRequest extends FormRequest
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
            "docno" => "required|string|unique:jurumdoc,docno",
            "jk" => "required|numeric",
            "suplesi" => "required|numeric",
            "store" => "required|numeric",
            "keterangan" => "required|string",
            "ci" => "required|numeric",
            "rate" => "required|numeric",
            "inputid" => "required|string",
            "inputdate" => "required|date_format:Y-m-d",
            "voucher" => "required|string",
            "mp" => "required|string", //
            "nomor" => "required|numeric", //
            "bulan" => "required|date_format:m", // 
            "tahun" => "required|date_format:Y", // 
            "bagian" => "required|string", // 
            "nama_bagian" => "required|string", //
            "nama_kas" => "required|string", //
        ];
    }
}
