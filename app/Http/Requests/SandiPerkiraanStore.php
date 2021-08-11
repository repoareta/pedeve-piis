<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SandiPerkiraanStore extends FormRequest
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
            'kodeacct' => 'unique:account,kodeacct|required|numeric',
            'descacct' => 'required|string',
        ];
    }
}
