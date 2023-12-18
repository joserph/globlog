<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pallet extends Model
{
    protected $fillable = [
        'counter', 'number', 'quantity', 'usda', 'id_load', 'id_user', 'update_user', 'in_pallet', 'coordination'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }
}
