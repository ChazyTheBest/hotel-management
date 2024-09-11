<?php declare(strict_types=1);

namespace App\Actions;

use App\Contracts\DeletesUsers;
use App\Models\User;

class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     */
    public function delete(User $user): void
    {
        // Don't forget to use a DB::transaction()
        $user->deleteAccountPhoto();
        //$user->tokens->each->delete();
        $user->delete();
    }
}
