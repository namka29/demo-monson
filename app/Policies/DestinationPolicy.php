<?php

namespace App\Policies;

use App\Models\Destination;
use App\Models\User;
use App\Policies\Concerns\HandlesStaffRoles;

class DestinationPolicy
{
    use HandlesStaffRoles;

    public function viewAny(User $user): bool
    {
        return $this->canManageContent($user);
    }

    public function view(User $user, Destination $destination): bool
    {
        return $this->canManageContent($user);
    }

    public function create(User $user): bool
    {
        return $this->canManageContent($user);
    }

    public function update(User $user, Destination $destination): bool
    {
        return $this->canManageContent($user);
    }

    public function delete(User $user, Destination $destination): bool
    {
        return $this->canDestroy($user);
    }

    public function deleteAny(User $user): bool
    {
        return $this->canDestroy($user);
    }
}
