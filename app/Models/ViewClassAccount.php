<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewClassAccount extends Model
{
    use HasFactory;

    protected $table = 'v_class_account';

    public function sub_class_account()
    {
        return $this->hasMany('App\Models\ViewSubClassAccount', 'urutan', 'urutan');
    }

    public function neraca()
    {
        return $this->hasMany('App\Models\ViewNeraca', 'sub_akun', 'batas_awal');
    }

    public function class_account()
    {
        return $this->hasMany('App\Models\ViewClassAccount', 'urutan_sc', 'urutan_sc');
    }

    public function class_account_by_sc()
    {
        return $this->hasMany('App\Models\ViewClassAccount', 'urutan_class', 'urutan_class');
    }
}
