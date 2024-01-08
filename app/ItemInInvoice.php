<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemInInvoice extends Model
{
    protected $fillable = [
        'description_id',
        'invoice_id',
        'pieces',
        'quantity',
        'rate',
        'amount',
        'id_user',
        'update_user',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }

    public function description()
    {
        return $this->belongsTo('App\ItemForInvoice', 'description_id');
    }
}
