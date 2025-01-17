<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\CompanyDetails;
use App\Models\User;

class CompanyDetailsPolicy
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
    public function view(User $user, CompanyDetails $companyDetails): bool
    {
        return $user->hasRoleOrHigher(Role::MANAGER);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CompanyDetails $companyDetails): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CompanyDetails $companyDetails): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CompanyDetails $companyDetails): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CompanyDetails $companyDetails): bool
    {
        //
    }
}
