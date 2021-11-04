<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulanPerbendaharaanStoreRequest extends FormRequest
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
            'tahun' => 'required|date_format:Y',
            'bulan' => 'required|date_format:m',
            'suplesi' => 'required|numeric',
            'keterangan' => 'required|string',
            'status' => 'required|string',
            'tanggal' => 'required_if:status,1|date_format:d-m-Y',
            'tanggal2' => 'nullable',
            'tanggal3' => 'required_if:status,3|date_format:d-m-Y',
        ];
    }

    public function attributes()
    {
        return [
            'tanggal' => 'Tanggal Opening',
            'tanggal2' => 'Tanggal Stoping',
            'tanggal3' => 'Tanggal Closing',
        ];
    }
}
