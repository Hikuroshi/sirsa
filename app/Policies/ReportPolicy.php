<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReportPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Report $report): Response
    {
        return $user->isSuperadmin()
            || ($user->isAdmin() && $user->organization_id === $report->organization_id)
            || $user->id === $report->reporter_id
                ? Response::allow()
                : Response::denyAsNotFound();
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Report $report): Response
    {
        return $user->isSuperadmin() || ($user->isAdmin() && $user->organization_id === $report->organization_id)
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function delete(User $user, Report $report): Response
    {
        return $this->update($user, $report);
    }

    public function restore(User $user, Report $report): bool
    {
        return false;
    }

    public function forceDelete(User $user, Report $report): bool
    {
        return false;
    }
}
