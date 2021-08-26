<?php

namespace App\Http\Requests;

use App\Rules\MoneyFormat;
use Illuminate\Foundation\Http\FormRequest;

class UpahTetapStoreRequest extends FormRequest
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
            'nilai_upah_tetap' => ['required', new MoneyFormat],
            'mulai_upah_tetap' => 'required|date_format:Y-m-d',
            'sampai_upah_tetap' => 'required|date_format:Y-m-d',
            'keterangan_upah_tetap' => 'nullable|string',
        ];
    }
}
