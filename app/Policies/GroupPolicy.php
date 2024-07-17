<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Group;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Group $group)
    {
        return $user->role == Role::ADMIN || $user->id == $group->user->id;
    }
}
