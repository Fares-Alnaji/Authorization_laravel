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
     * @param Admin $admin
     * @return bool
     */
    public function viewAny(Admin $admin)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     * @param Admin $admin
     * @param City $city
     * @return bool
     */
    public function view(Admin $admin, City $city)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     * @param Admin $admin
     * @return bool
     */
    public function create(Admin $admin)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *  @param Admin $admin
     * @param City $city
     * @return bool
     */
    public function update(Admin $admin, City $city)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     * @param Admin $admin
     * @param City $city
     *
     */
    public function delete(Admin $admin, City $city)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     * @param Admin $admin
     * @param City $city
     * @return bool
     */
    public function restore(Admin $admin, City $city)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *  @param Admin $admin
     * @param City $city
     * @return bool
     */
    public function forceDelete(Admin $admin, City $city)
    {
        //
    }
}
