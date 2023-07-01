<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     * @param \App\Model\Admin $admin
     * @return bool
     */
    public function viewAny(Admin $admin)
    {
        //
        return $admin->hasPermissionTo('Read-Roles')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the user can view the model.
     * @param \App\Model\Admin $admin
     * @param \App\Model\Role $role
     * @return bool
     */
    public function view(Admin $admin, Role $role)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     * @param \App\Model\Admin $admin
     * @return bool
     */
    public function create(Admin $admin)
    {
        //
        return $admin->hasPermissionTo('Create-Role')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the user can update the model.
     * @param \App\Model\Admin $admin
     * @param \App\Model\Role $role
     * @return bool
     */
    public function update(Admin $admin, Role $role)
    {
        //
        return $admin->hasPermissionTo('Update-Role')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the user can delete the model.
     * @param \App\Model\Admin $admin
     * @param \App\Model\Role $role
     * @return bool
     */
    public function delete(Admin $admin, Role $role)
    {
        //
        return $admin->hasPermissionTo('Delete-Role')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Role $role)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Role $role)
    {
        //
    }
}
