<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JurnalUmumUpdateRequest extends FormRequest
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
            "docno" => "required|string",
            "jk" => "required|numeric",
            "ci" => "required|numeric",
            "suplesi" => "required|numeric",
            "keterangan" => "required|string",
            "bulan" => "required|date_format:m",
            "tahun" => "required|date_format:Y",
        ];
    }
}
