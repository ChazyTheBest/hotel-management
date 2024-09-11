<?php declare(strict_types=1);

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;
use App\Models\ViewDefinition;

class ViewDefinitionPolicy
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
    public function view(User $user, ViewDefinition $viewDefinition): bool
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
    public function update(User $user, ViewDefinition $viewDefinition): bool
    {
        return $user->hasRoleOrHigher(Role::MANAGER);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ViewDefinition $viewDefinition): bool
    {
        return $user->hasRole(Role::ADMIN);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ViewDefinition $viewDefinition): bool
    {
        return $user->hasRole(Role::ADMIN);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ViewDefinition $viewDefinition): bool
    {
        return $user->hasRole(Role::ADMIN);
    }
}
