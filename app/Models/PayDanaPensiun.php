<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayDanaPensiun extends Model
{
    use HasFactory;

    protected $table="pay_tbl_danapensiun";
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
}
