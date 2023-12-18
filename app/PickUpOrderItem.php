<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PickUpOrderItem extends Model
{
    protected $fillable = [
        'awb',
        'description',
        'pieces',
        'pallets',
        'id_pickup',
        'id_user',
        'update_user'
    ];
}
