<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperadmin() || ($user->isAdmin() && $user->organization_id !== null);
    }

    public function view(User $user, User $target): Response
    {
        return $user->isSuperadmin()
            || ($user->isAdmin() && $user->organization_id !== null && $user->organization_id === $target->organization_id)
                ? Response::allow()
                : Response::denyAsNotFound();
    }

    public function create(User $user): bool
    {
        return $this->viewAny($user);
    }

    public function update(User $user, User $target): Response
    {
        return $this->view($user, $target);
    }

    public function delete(User $user, User $target): Response
    {
        return $this->view($user, $target);
    }
}
