<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class API_Locations extends Model
{
    public $table = "API_Locations";
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
