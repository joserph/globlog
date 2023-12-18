<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sketch extends Model
{
    protected $fillable = [
        'space',
        'id_pallet',
        'id_load',
        'id_user',
        'update_user'
    ];

    public function pallet()
    {
        return $this->belongsTo('App\Pallet', 'id_pallet');
    }

}
