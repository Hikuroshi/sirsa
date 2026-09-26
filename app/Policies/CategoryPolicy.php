<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperadmin() || ($user->isAdmin() && $user->organization_id !== null);
    }

    public function view(User $user, Category $category): Response
    {
        return $user->isSuperadmin()
            || ($user->isAdmin() && $user->organization_id !== null && $user->organization_id === $category->organization_id)
                ? Response::allow()
                : Response::denyAsNotFound();
    }

    public function create(User $user): bool
    {
        return $this->viewAny($user);
    }

    public function update(User $user, Category $category): Response
    {
        return $this->view($user, $category);
    }

    public function delete(User $user, Category $category): Response
    {
        return $this->view($user, $category);
    }
}
