<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenerimaanKasStoreRequest extends FormRequest
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
            "user_id" => "required",
            "nomor" => "required",
            "tanggal_buku" => "required",
            "tanggal" => "required",
            "mp" => "required",
            "bulan_buku" => "required",
            "tahun_buku" => "required",
            "bagian" => "required|string",
            "jenis_kartu" => "required|numeric",
            "currency_index" => "required|numeric",
            "kurs" => "required|numeric",
            "lokasi" => "required|numeric",
            "no_bukti" => "required|numeric",
            "no_ver" => "required|numeric",
            "kepada" => "required|string",
            "nilai" => "required|numeric",
            "iklan" => "nullable|string",
            "keterangan-1" => "nullable|string",
            "keterangan-2" => "nullable|string",
            "keterangan-3" => "nullable|string",
        ];
    }
}
