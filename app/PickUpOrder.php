<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PickUpOrder extends Model
{
    protected $fillable = [
        'date',
        'loading_date',
        'loading_hour',
        'carrier_company',
        'driver_name',
        'carrier_num',
        'pick_up_location',
        'pick_up_address',
        'city_pu',
        'state_pu',
        'zip_code_pu',
        'country_pu',
        'consigned_to',
        'drop_off_address',
        'city_do',
        'state_do',
        'zip_code_do',
        'country_do',
        'id_user',
        'update_user'
    ];
}
