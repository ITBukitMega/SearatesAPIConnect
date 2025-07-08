<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstTracking extends Model
{
    public $table = "MstTracking";
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['blnumber', 'type', 'sealine', 'sealine_name', 'status', 'syncTime'];
}
