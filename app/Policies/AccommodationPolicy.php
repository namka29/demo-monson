<?php

namespace App\Policies;

use App\Models\Accommodation;
use App\Models\User;
use App\Policies\Concerns\HandlesStaffRoles;

class AccommodationPolicy
{
    use HandlesStaffRoles;

    public function viewAny(User $user): bool
    {
        return $this->canManageContent($user);
    }

    public function view(User $user, Accommodation $accommodation): bool
    {
        return $this->canManageContent($user);
    }

    public function create(User $user): bool
    {
        return $this->canManageContent($user);
    }

    public function update(User $user, Accommodation $accommodation): bool
    {
        return $this->canManageContent($user);
    }

    public function delete(User $user, Accommodation $accommodation): bool
    {
        return $this->canDestroy($user);
    }

    public function deleteAny(User $user): bool
    {
        return $this->canDestroy($user);
    }
}
