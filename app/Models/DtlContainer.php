<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DtlContainer extends Model
{
    public $table = 'DtlContainer';
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
