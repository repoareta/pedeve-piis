<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewNeraca extends Model
{
    use HasFactory;

    protected $table = 'v_neraca';

    public function andet()
    {
        return $this->belongsTo('App\Models\ViewAndet', 'sandi', 'sandi');
    }
}
