<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class API_Container extends Model
{
    public $table = 'API_Container';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'blnumber',
        'number',
        'iso_code',
        'size_type',
        'status',
        'syncTime',
    ];
}
