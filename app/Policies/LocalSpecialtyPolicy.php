<?php

namespace App\Policies;

use App\Models\LocalSpecialty;
use App\Models\User;
use App\Policies\Concerns\HandlesStaffRoles;

class LocalSpecialtyPolicy
{
    use HandlesStaffRoles;

    public function viewAny(User $user): bool
    {
        return $this->canManageContent($user);
    }

    public function view(User $user, LocalSpecialty $localSpecialty): bool
    {
        return $this->canManageContent($user);
    }

    public function create(User $user): bool
    {
        return $this->canManageContent($user);
    }

    public function update(User $user, LocalSpecialty $localSpecialty): bool
    {
        return $this->canManageContent($user);
    }

    public function delete(User $user, LocalSpecialty $localSpecialty): bool
    {
        return $this->canDestroy($user);
    }

    public function deleteAny(User $user): bool
    {
        return $this->canDestroy($user);
    }
}
