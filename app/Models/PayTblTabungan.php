<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayTblTabungan extends Model
{
    use HasFactory;

    protected $table= "pay_tbl_tabungan";
    protected $primaryKey = "perusahaan";
    public $incrementing = false;
    public $keyType = 'string';
    public $timestamps = false;
}
