<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class API_Vessel extends Model
{
    public $table = 'API_Vessel';
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
