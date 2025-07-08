<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DtlVessel extends Model
{
    public $table = 'DtlVessel';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'blnumber',
        'api_id',
        'name',
        'imo',
        'call_sign',
        'mmsi',
        'flag',
        'syncTime'
    ];
}
