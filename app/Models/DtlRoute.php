<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DtlRoute extends Model
{
    public $table = 'Dtl_Route';
    protected $primaryKey = 'id';
    public $timestamps = false;


    protected $fillable = [
        'blnumber',
        'route_type',
        'location',
        'date',
        'actual',
        'predictive_eta'
    ];
}
