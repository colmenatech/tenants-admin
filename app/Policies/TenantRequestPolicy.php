<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TenantRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class TenantRequestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the tenantRequest can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the tenantRequest can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TenantRequest  $model
     * @return mixed
     */
    public function view(User $user, TenantRequest $model)
    {
        return true;
    }

    /**
     * Determine whether the tenantRequest can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the tenantRequest can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TenantRequest  $model
     * @return mixed
     */
    public function update(User $user, TenantRequest $model)
    {
        return true;
    }

    /**
     * Determine whether the tenantRequest can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TenantRequest  $model
     * @return mixed
     */
    public function delete(User $user, TenantRequest $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TenantRequest  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the tenantRequest can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TenantRequest  $model
     * @return mixed
     */
    public function restore(User $user, TenantRequest $model)
    {
        return false;
    }

    /**
     * Determine whether the tenantRequest can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TenantRequest  $model
     * @return mixed
     */
    public function forceDelete(User $user, TenantRequest $model)
    {
        return false;
    }
}
