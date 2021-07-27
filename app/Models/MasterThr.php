<?php

namespace App\Models;

use App\Traits\CompositeKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterThr extends Model
{
    use HasFactory;

    use CompositeKey;
    
    protected $table = "pay_master_thr";
    protected $primaryKey = ['tahun', 'bulan', 'nopek', 'aard'];
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;

    public function pekerja()
    {
        return $this->belongsTo('App\Models\MasterPegawai', 'nopek');
    }

    public function aard_payroll()
    {
        return $this->belongsTo('App\Models\AardPayroll', 'aard');
    }
}
