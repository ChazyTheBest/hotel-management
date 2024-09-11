<?php declare(strict_types=1);

namespace App\Policies;

use App\Enums\Role;
use App\Models\Profile;
use App\Models\User;

class ProfilePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Profile $profile): bool
    {
        return $user->hasRole(Role::STAFF) || $user->id === $profile->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Profile $profile): bool
    {
        return $user->hasRole(Role::STAFF) || $user->id === $profile->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Profile $profile): bool
    {
        return $user->hasRole(Role::STAFF) || $user->id === $profile->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Profile $profile): bool
    {
        return $user->hasRole(Role::STAFF);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Profile $profile): bool
    {
        return $user->hasRole(Role::STAFF);
    }
}