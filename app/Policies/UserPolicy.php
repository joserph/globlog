<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $userA
     * @return mixed
     */
    public function viewAny(User $userA)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $userA
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $userA, User $user, $perm = null)
    {
        if($userA->havePermission($perm[0]))
        {
            return true;
        }else if($userA->havePermission($perm[1]))
        {
            return $userA->id === $user->id;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $userA
     * @return mixed
     */
    public function create(User $userA)
    {
        return $userA->id > 0;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $userA
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $userA, User $user, $perm = null)
    {
        if($userA->havePermission($perm[0]))
        {
            return true;
        }else if($userA->havePermission($perm[1]))
        {
            return $userA->id === $user->id;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $userA
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $userA, User $user)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $userA
     * @param  \App\User  $user
     * @return mixed
     */
    public function restore(User $userA, User $user)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $userA
     * @param  \App\User  $user
     * @return mixed
     */
    public function forceDelete(User $userA, User $user)
    {
        //
    }
}
