<?php

namespace App\Policies;

use App\Models\HeroSlideshowSetting;
use App\Models\User;
use App\Policies\Concerns\HandlesStaffRoles;

class HeroSlideshowSettingPolicy
{
    use HandlesStaffRoles;

    public function viewAny(User $user): bool
    {
        return $this->canManageContent($user);
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function view(User $user, HeroSlideshowSetting $heroSlideshowSetting): bool
    {
        return $this->canManageContent($user);
    }

    public function update(User $user, HeroSlideshowSetting $heroSlideshowSetting): bool
    {
        return $this->canManageContent($user);
    }

    public function delete(User $user, HeroSlideshowSetting $heroSlideshowSetting): bool
    {
        return false;
    }

    public function deleteAny(User $user): bool
    {
        return false;
    }
}
