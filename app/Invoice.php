<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'client_id',
        'num_invoice', 
        'count', 
        'load_id', 
        'flight_id', 
        'date',
        'terms',
        'type',
        'load_type',
        'total_pieces',
        'total_quantity',
        'total_amount',
        'id_user',
        'update_user',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }

    public function client()
    {
        return $this->belongsTo('App\Client', 'client_id');
    }
}
