<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\City;
use Illuminate\Auth\Access\HandlesAuthorization;

class CityPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     *
     * @param $actor
     * @return bool
     */
    public function viewAny($actor)
    {
        //
        return $actor->hasPermissionTo('Read-Cities')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the user can view the model.
     * @param $actor
     * @param City $city
     * @return bool
     */
    public function view($actor, City $city)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     * @param $actor
     * @return bool
     */
    public function create($actor)
    {
        //
        return $actor->hasPermissionTo('Create-City')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the user can update the model.
     *  @param $actor
     * @param City $city
     * @return bool
     */
    public function update($actor, City $city)
    {
        //
        return $actor->hasPermissionTo('Update-City')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the user can delete the model.
     * @param $actor
     * @param City $city
     *
     */
    public function delete($actor, City $city)
    {
        //
        return $actor->hasPermissionTo('Delete-City')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the user can restore the model.
     * @param $actor
     * @param City $city
     * @return bool
     */
    public function restore($actor, City $city)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *  @param $actor
     * @param City $city
     * @return bool
     */
    public function forceDelete($actor, City $city)
    {
        //
    }
}
