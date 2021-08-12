<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulanKontrolerUpdate extends FormRequest
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
            'bulan' => 'required|numeric',
            'tahun' => 'required|numeric',
            'suplesi' => 'required|numeric',
            'status' => 'required|in:1,2,3',
            'status' => 'required|in:1,2,3',
            'opendate' => 'nullable|date',
            'stopdate' => 'nullable|date',
            'closedate' => 'nullable|date',
            'keterangan' => 'required|string',
        ];
    }
}
