<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LemburStoreRequest extends FormRequest
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
            "tanggal" => "required|date_format:d-m-Y",
            "userid" => "required",
            "bulan" => "required",
            "tahun" => "required|date_format:Y",
            "nopek" => "required|unique:pay_lembur,nopek",
            "makanpg" => "required|numeric",
            "makansg" => "required|numeric",
            "makanml" => "required|numeric",
            "transport" => "required|numeric",
            "lembur" => "required|numeric",
        ];
    }
    
    /**
     * attributes
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'nopek' => 'Pegawai'
        ];
    }
}
