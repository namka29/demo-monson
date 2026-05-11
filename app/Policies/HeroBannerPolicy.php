<?php

namespace App\Policies;

use App\Models\HeroBanner;
use App\Models\User;
use App\Policies\Concerns\HandlesStaffRoles;

class HeroBannerPolicy
{
    use HandlesStaffRoles;

    public function viewAny(User $user): bool
    {
        return $this->canManageContent($user);
    }

    public function view(User $user, HeroBanner $heroBanner): bool
    {
        return $this->canManageContent($user);
    }

    public function create(User $user): bool
    {
        return $this->canManageContent($user);
    }

    public function update(User $user, HeroBanner $heroBanner): bool
    {
        return $this->canManageContent($user);
    }

    public function delete(User $user, HeroBanner $heroBanner): bool
    {
        return $this->canDestroy($user);
    }

    public function deleteAny(User $user): bool
    {
        return $this->canDestroy($user);
    }

    /**
     * Thứ tự slide trong bảng Filament (kéo-thả).
     */
    public function reorder(User $user): bool
    {
        return $this->canManageContent($user);
    }
}

