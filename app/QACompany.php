<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QACompany extends Model
{
    protected $fillable = [
        'name',
        'owner',
        'address',
        'phone',
        'state',
        'city',
        'country',
        'email',
        'id_user',
        'update_user'
    ];
    
}
