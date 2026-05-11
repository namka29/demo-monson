<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use App\Policies\Concerns\HandlesStaffRoles;

class PostPolicy
{
    use HandlesStaffRoles;

    public function viewAny(User $user): bool
    {
        return $this->canManageContent($user);
    }

    public function view(User $user, Post $post): bool
    {
        return $this->canManageContent($user);
    }

    public function create(User $user): bool
    {
        return $this->canManageContent($user);
    }

    public function update(User $user, Post $post): bool
    {
        return $this->canManageContent($user);
    }

    public function delete(User $user, Post $post): bool
    {
        return $this->canDestroy($user);
    }

    public function deleteAny(User $user): bool
    {
        return $this->canDestroy($user);
    }
}
