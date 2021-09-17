<?php

namespace App\Http\Requests;

use App\Rules\MoneyFormat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Request;

class PPerjalananDinasDetailUpdate extends FormRequest
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
            'no_urut' => [
                'required',
                'numeric',
                Rule::unique('ppanjar_detail', 'no')
                ->ignore(Request::segment(7), 'no')
                ->where(function ($query) {
                    $query->where('no_ppanjar', str_replace(
                        '-',
                        '/',
                        Request::segment(4)
                    ))
                    ->where('no', $this->request->get('no_urut'));
                })
            ],
            'nopek' => 'required',
            'keterangan' => 'required',
            'nilai' => ['required', new MoneyFormat, 'max:30'],
            'qty' => ['required', new MoneyFormat, 'max:30'],
        ];
    }
}
