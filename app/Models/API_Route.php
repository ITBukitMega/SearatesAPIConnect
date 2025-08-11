<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class API_Route extends Model
{
    public $table = 'API_Route';
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
