<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetUserUpdate extends FormRequest
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
            'userid' => 'required', 
            'usernm'      => 'required',
            'kode'        => 'required',
            'userlv'      => 'required',
            'nopeg'       => 'required|exists:App\Models\MasterPegawai,nopeg',
            'gcg_jabatan_id' => 'required|exists:App\Models\GcgJabatan,id',
            'gcg_fungsi_id' => 'required|exists:App\Models\GcgFungsi,id',
        ];
    }
}
