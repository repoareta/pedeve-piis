<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayTblRekening extends Model
{
    use HasFactory;

    protected $table="pay_tbl_rekening";
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
}
