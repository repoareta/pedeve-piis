<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayTabungan extends Model
{
    use HasFactory;

    protected $table="pay_tbl_tabungan";
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
}
