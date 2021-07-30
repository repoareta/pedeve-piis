<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayTblBank extends Model
{
    use HasFactory;

    protected $table="pay_tbl_bank";
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
}
