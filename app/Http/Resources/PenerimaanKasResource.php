<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PenerimaanKasResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'no_dok' => $this->docno,
            'tanggal' => date('d F Y', strtotime($this->originaldate)),
            'year_in_string' => $this->thnbln,
            'jk' => $this->jk,
            'store' => isset($this->storejk->namabank) ? ( $this->store . ' -- ' . $this->storejk->namabank) : null,
            'ci' => $this->ci,
            'voucher' => $this->voucher,
            'kepada' => $this->kepada,
            'rate' => currency_format($this->rate),
            'nilai_dokumen' => currency_format($this->nilai_doc),
            'status_paid' => $this->paid,
            'status_verified' => $this->verified,
            'nama_bank' => $this->storejk->namabank ?? null,
        ];
    }
}
