<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Request;

class PerjalananDinasDetailStore extends FormRequest
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
            'no_urut'    => [
                "required",
                "numeric",
                Rule::unique('panjar_detail', 'no')->where(function ($query) {
                    $query->where('no_panjar', str_replace(
                        '-',
                        '/',
                        Request::segment(3)
                    ))
                    ->where('no', $this->request->get('no_urut'));
                })
            ],
            'keterangan' => 'required',
            'nopek'      => 'required',
            'jabatan'    => 'required',
            'golongan'   => 'required',
        ];
    }
}
