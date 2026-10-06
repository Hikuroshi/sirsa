<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Category $category): Response
    {
        return $user->isAdmin() ? Response::allow() : Response::denyAsNotFound();
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
