<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TabelMenuStore extends FormRequest
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
            'menuid'      => 'required|unique:App\Models\DftMenu,menuid|max:3|numeric',
            'menunm'      => 'required',
            'userap'      => 'required',
        ];
    }
}
