<?php

namespace App\PermissionFolder\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    // From here
    protected $fillable = [
        'name', 'slug', 'description',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\PermissionFolder\Models\Role')->withTimesTamps();
    }
}
