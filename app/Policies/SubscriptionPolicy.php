<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Subscription;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubscriptionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the subscription can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the subscription can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Subscription  $model
     * @return mixed
     */
    public function view(User $user, Subscription $model)
    {
        return true;
    }

    /**
     * Determine whether the subscription can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the subscription can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Subscription  $model
     * @return mixed
     */
    public function update(User $user, Subscription $model)
    {
        return true;
    }

    /**
     * Determine whether the subscription can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Subscription  $model
     * @return mixed
     */
    public function delete(User $user, Subscription $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Subscription  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the subscription can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Subscription  $model
     * @return mixed
     */
    public function restore(User $user, Subscription $model)
    {
        return false;
    }

    /**
     * Determine whether the subscription can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Subscription  $model
     * @return mixed
     */
    public function forceDelete(User $user, Subscription $model)
    {
        return false;
    }
}
