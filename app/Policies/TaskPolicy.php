<?php

namespace App\Policies;

use App\Models\Task;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;


class TaskPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     * @param $user
     * @return bool
     */
    public function viewAny($user)
    {
        //
        return $user->hasPermissionTo('Read-Tasks')
          ? $this->allow() : $this->deny();
    }

    /**
     * Determine whether the user can view the model.
     *  @param $user
     * @param Task $task
     * @return bool
     */
    public function view($user, Task $task)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     * @param $user
     * @return bool
     */
    public function create($user)
    {
        //
        return $user->hasPermissionTo('Create-Task')
        ? $this->allow() : $this->deny();
    }

    /**
     * Determine whether the user can update the model.
     *  @param $user
     * @param Task $task
     * @return bool
     */
    public function update($user, Task $task)
    {
        //
        return $user->hasPermissionTo('Update-Task') && $task->user_id == $user->id
        ? $this->allow() : $this->deny();
    }

    /**
     * Determine whether the user can delete the model.
     * @param $user
     * @param Task $task
     */
    public function delete($user, Task $task)
    {
        //
        return $user->hasPermissionTo('Delete-Task') && (auth('admin')->check()
         || $user->id == $task->user_id)
          ? $this->allow() : $this->deny();
    }

    /**
     * Determine whether the user can restore the model.
     * @param $user
     * @param Task $task
     * @return bool
     */
    public function restore($user, Task $task)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     * @param $user
     * @param Task $task
     * @return bool
     */
    public function forceDelete($user, Task $task)
    {
        //
    }
}
