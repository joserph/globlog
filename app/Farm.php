<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Farm extends Model
{
    protected $fillable = [
        'name',
        'tradename',
        'phone',
        'address',
        'state', // Estado
        'city', // Ciudad
        'country',
        'id_user',
        'update_user',
        'ruc'
    ];

    public function masterinvoiceitems()
    {
        return $this->hasMany('App\MasterInvoiceItem', 'id_farm');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }
}
