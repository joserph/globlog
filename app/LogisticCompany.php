<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogisticCompany extends Model
{
    protected $fillable = [
        'name',
        'ruc',
        'phone',
        'address',
        'state', // Estado
        'city', // Ciudad
        'country',
        'active',
        'id_user',
        'update_user'
    ];
}
