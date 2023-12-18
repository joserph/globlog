<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dae extends Model
{
    protected $fillable = [
        'destination_country',
        'num_dae',
        'id_farm',
        'date',
        'arrival_date',
        'id_user',
        'update_user',
    ];

    public function farm()
    {
        return $this->belongsTo('App\Farm', 'id_farm');
    }
}
