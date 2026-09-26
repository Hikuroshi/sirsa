<?php

namespace App\Policies;

use App\Models\AiApiKey;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AiApiKeyPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperadmin() || ($user->isAdmin() && $user->organization_id !== null);
    }

    public function view(User $user, AiApiKey $aiApiKey): Response
    {
        $allowed = $user->isSuperadmin()
            ? $aiApiKey->organization_id === null
            : $user->isAdmin()
                && $user->organization_id !== null
                && $user->organization_id === $aiApiKey->organization_id;

        return $allowed ? Response::allow() : Response::denyAsNotFound();
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
