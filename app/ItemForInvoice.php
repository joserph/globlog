<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemForInvoice extends Model
{
    protected $fillable = [
        'name',
        'id_user',
        'update_user',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }
}
