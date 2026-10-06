<?php

namespace App\Policies;

use App\Models\AiModelLimit;
use App\Models\User;

class AiModelLimitPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, AiModelLimit $aiModelLimit): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, AiModelLimit $aiModelLimit): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, AiModelLimit $aiModelLimit): bool
    {
        return $user->isAdmin();
    }
}
