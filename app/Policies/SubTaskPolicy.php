<?php

namespace App\Policies;

use App\Models\SubTask;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubTaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SubTask  $subTask
     * @return mixed
     */
    public function view(User $user, SubTask $subTask)
    {
        return $subTask->task->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SubTask  $subTask
     * @return mixed
     */
    public function update(User $user, SubTask $subTask)
    {
        return $subTask->task->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SubTask  $subTask
     * @return mixed
     */
    public function delete(User $user, SubTask $subTask)
    {
        return $subTask->task->user_id == $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SubTask  $subTask
     * @return mixed
     */
    public function restore(User $user, SubTask $subTask)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SubTask  $subTask
     * @return mixed
     */
    public function forceDelete(User $user, SubTask $subTask)
    {
        //
    }
}
