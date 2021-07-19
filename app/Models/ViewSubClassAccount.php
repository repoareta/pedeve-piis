<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewSubClassAccount extends Model
{
    use HasFactory;

    protected $table = 'v_sub_class_account';

    public function neraca()
    {
        return $this->hasMany('App\Models\ViewNeraca', 'urutan', 'urutan');
    }
}
