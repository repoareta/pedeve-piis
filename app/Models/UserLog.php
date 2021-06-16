<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    use HasFactory;

    protected $table="userlog";
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
}
