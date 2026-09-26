<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;

class ReportPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Report $report): bool
    {
        return $user->isSuperadmin()
            || ($user->isAdmin() && $user->organization_id === $report->organization_id)
            || $user->id === $report->reporter_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Report $report): bool
    {
        return $user->isSuperadmin()
            || ($user->isAdmin() && $user->organization_id === $report->organization_id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Report $report): bool
    {
        return $this->update($user, $report);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Report $report): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Report $report): bool
    {
        return false;
    }
}
