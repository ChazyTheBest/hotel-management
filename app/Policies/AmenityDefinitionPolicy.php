<?php declare(strict_types=1);

namespace App\Policies;

use App\Enums\Role;
use App\Models\AmenityDefinition;
use App\Models\User;

class AmenityDefinitionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRoleOrHigher(Role::STAFF);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AmenityDefinition $amenityDefinition): bool
    {
        return $user->hasRoleOrHigher(Role::MANAGER);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRoleOrHigher(Role::MANAGER);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AmenityDefinition $amenityDefinition): bool
    {
        return $user->hasRoleOrHigher(Role::MANAGER);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AmenityDefinition $amenityDefinition): bool
    {
        return $user->hasRole(Role::ADMIN);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AmenityDefinition $amenityDefinition): bool
    {
        return $user->hasRole(Role::ADMIN);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AmenityDefinition $amenityDefinition): bool
    {
        return $user->hasRole(Role::ADMIN);
    }
}