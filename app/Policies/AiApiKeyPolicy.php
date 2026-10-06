<?php

namespace App\Policies;

use App\Models\AiApiKey;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AiApiKeyPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, AiApiKey $aiApiKey): Response
    {
        return $user->isAdmin() ? Response::allow() : Response::denyAsNotFound();
    }

    public function create(User $user): bool
    {
        return $this->viewAny($user);
    }

    public function update(User $user, AiApiKey $aiApiKey): Response
    {
        return $this->view($user, $aiApiKey);
    }

    public function delete(User $user, AiApiKey $aiApiKey): Response
    {
        return $this->view($user, $aiApiKey);
    }
}
