<?php

namespace App\Policies;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrganizationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperadmin() || $user->isAdmin();
    }

    public function view(User $user, Organization $organization): Response
    {
        return $user->isSuperadmin() || ($user->isAdmin() && $user->organization_id === $organization->id)
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function create(User $user): bool
    {
        return $user->isSuperadmin() || ($user->isAdmin() && $user->organization_id === null);
    }

    public function update(User $user, Organization $organization): Response
    {
        return $this->view($user, $organization);
    }

    public function delete(User $user, Organization $organization): bool
    {
        return $user->isSuperadmin();
    }

    public function restore(User $user, Organization $organization): bool
    {
        return false;
    }

    public function forceDelete(User $user, Organization $organization): bool
    {
        return false;
    }
}
