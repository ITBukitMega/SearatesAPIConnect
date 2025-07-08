<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DtlLocation extends Model
{
    public $table = "DtlLocation";
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'api_id',
        'blnumber',
        'name',
        'state',
        'country',
        'country_code',
        'locode',
        'lat',
        'lng',
        'timezone',
        'syncTime',
    ];
}
