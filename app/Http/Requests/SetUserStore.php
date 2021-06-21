<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetUserStore extends FormRequest
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
            'userid'      => 'required|unique:App\Models\UserPdv,userid',
            'usernm'      => 'required',
            'kode'        => 'required',
            'userlv'      => 'required',
            'nopeg'       => 'required|unique:App\Models\Pekerja,nopeg|exists:App\Models\Pekerja,nopeg',
            'gcg_jabatan_id' => 'required|exists:App\Models\GcgJabatan,id',
            'gcg_fungsi_id' => 'required|exists:App\Models\GcgFungsi,id',
        ];
    }
}
