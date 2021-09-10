<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MoneyFormat;
class LemburUpdateRequest extends FormRequest
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
            "tanggal" => "required|date_format:d/m/Y",
            "userid" => "required",
            "bulan" => "required",
            "tahun" => "required|date_format:Y",
            "nopek" => "required",
            "makanpg" => ['required', new MoneyFormat, 'max:14'],
            "makansg" => ['required', new MoneyFormat, 'max:14'],
            "makanml" => ['required', new MoneyFormat, 'max:14'],
            "transport" => ['required', new MoneyFormat, 'max:14'],
            "lembur" => ['required', new MoneyFormat, 'max:14'],
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
