<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    protected $fillable = [
        'awb',
        'carrier',
        'date',
        'arrival_date',
        'id_user',
        'update_user',
        'code',
        'brand',
        'type_awb',
        'status',
        'origin_city',
        'origin_country',
        'destination_city',
        'destination_country'
    ];

    public function airline()
    {
        return $this->belongsTo('App\Airline', 'carrier');
    }
}
