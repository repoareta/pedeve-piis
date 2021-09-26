<?php

namespace App\Http\Requests;

use App\Rules\MoneyFormat;
use Illuminate\Foundation\Http\FormRequest;

class MasterTabunganStoreRequest extends FormRequest
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
            'perusahaan' => ['required', new MoneyFormat, 'max:30'],
        ];
    }
}
