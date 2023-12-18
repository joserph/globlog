<?php

namespace App\PermissionFolder\Traits;

trait UserTrait {
    // From here
    public function roles()
    {
        return $this->belongsToMany('App\PermissionFolder\Models\Role')->withTimesTamps();
    }

    public function havePermission($permission)
    {
        foreach($this->roles as $role)
        {
            if($role['full_access'] == 'yes')
            {
                return true;
            }

            foreach($role->permissions as $perm)
            {
                if($perm->slug == $permission)
                {
                    return true;
                }
            }
        }
        return false;
        //return $this->roles;
    }
}