<?php

namespace App\Policies\Concerns;

use App\Models\User;

trait HandlesStaffRoles
{
    protected function canManageContent(User $user): bool
    {
        return $user->canAccessAdminPanel();
    }

    protected function canDestroy(User $user): bool
    {
        return $user->isAdmin();
    }
}
