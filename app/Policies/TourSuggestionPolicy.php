<?php

namespace App\Policies;

use App\Models\TourSuggestion;
use App\Models\User;
use App\Policies\Concerns\HandlesStaffRoles;

class TourSuggestionPolicy
{
    use HandlesStaffRoles;

    public function viewAny(User $user): bool
    {
        return $this->canManageContent($user);
    }

    public function view(User $user, TourSuggestion $tourSuggestion): bool
    {
        return $this->canManageContent($user);
    }

    public function create(User $user): bool
    {
        return $this->canManageContent($user);
    }

    public function update(User $user, TourSuggestion $tourSuggestion): bool
    {
        return $this->canManageContent($user);
    }

    public function delete(User $user, TourSuggestion $tourSuggestion): bool
    {
        return $this->canDestroy($user);
    }

    public function deleteAny(User $user): bool
    {
        return $this->canDestroy($user);
    }
}
