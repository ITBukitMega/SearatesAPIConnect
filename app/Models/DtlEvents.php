<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DtlEvents extends Model
{
    public $table = 'DtlEvents';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'blnumber',
        'no_container',
        'order_id',
        'location',
        'facility',
        'description',
        'event_type',
        'event_code',
        'status',
        'date',
        'actual',
        'is_date_from_sealine',
        'is_additional_event',
        'type',
        'transport_type',
        'vessel',
        'voyage',
    ];
}
