<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;
use App\Models\Transcribe;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class TranscribePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->role == Role::ADMIN;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transcribe  $transcribe
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Transcribe $transcribe)
    {
        return $user->role == Role::ADMIN || $user->id == $transcribe->project->user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, Project $project)
    {
        return $user->role == Role::ADMIN || $user->id == $project->user->id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transcribe  $transcribe
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Transcribe $transcribe)
    {
        return $user->role == Role::ADMIN || $user->id == $transcribe->project->user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transcribe  $transcribe
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Transcribe $transcribe)
    {
        return $user->role == Role::ADMIN || $user->id == $transcribe->project->user->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transcribe  $transcribe
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Transcribe $transcribe)
    {
        return $user->role == Role::ADMIN || $user->id == $transcribe->project->user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transcribe  $transcribe
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Transcribe $transcribe)
    {
        return $user->role == Role::ADMIN || $user->id == $transcribe->project->user->id;
    }
}
