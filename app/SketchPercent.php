<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SketchPercent extends Model
{
    protected $fillable = [
        'percent',
        'id_client',
        'id_pallet',
        'id_load',
        'id_user',
        'update_user'
    ];

    public function pallet()
    {
        return $this->belongsTo('App\Pallet', 'id_pallet');
    }

    public function client()
    {
        return $this->belongsTo('App\Client', 'id_client');
    }

    /*public function load()
    {
        return $this->belongsTo('App\Load', 'id_load');
    }*/

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }
}
