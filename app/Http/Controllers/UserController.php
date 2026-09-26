<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', User::class);
        $query = User::query()
            ->search($request->string('search')->trim()->toString())
            ->latest();

        if ($request->user()->isAdmin()) {
            $query->where('organization_id', $request->user()->organization_id);
        } else {
            $query
                ->with([
                    'createdOrganizations' => fn ($query) => $query
                        ->withCount(['categories', 'reports', 'aiApiKeys'])
                        ->with('aiApiKeys:id,organization_id,name'),
                ])
                ->withCount(['reports', 'verifiedReports', 'statusChanges']);
        }

        $users = $query->paginate(10)->withQueryString();
        $deletionWarnings = $users->getCollection()->mapWithKeys(fn (User $user): array => [
            $user->id => $this->deletionWarning($user, $request->user()->isSuperadmin()),
        ]);

        return view('user.index', [
            'title' => $request->user()->isSuperadmin() ? 'Daftar Pengguna' : 'Pengguna Organisasi',
            'users' => $users,
            'deletionWarnings' => $deletionWarnings,
        ]);
    }

    public function create(Request $request): View
    {
        Gate::authorize('create', User::class);

        return view('user.form', [
            'title' => 'Tambah Pengguna',
            'roles' => $this->availableRoles($request),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', User::class);
        $validated = $this->validateUser($request, passwordRequired: true);

        User::create([
            ...$validated,
            'organization_id' => $request->user()->isAdmin() ? $request->user()->organization_id : null,
        ]);

        return redirect()->route('user.index')->with('success', 'Pengguna berhasil dibuat.');
    }

    public function show(Request $request, User $user): View
    {
        Gate::authorize('view', $user);

        return view('user.show', [
            'title' => 'Detail Pengguna',
            'user' => $user,
        ]);
    }

    public function edit(Request $request, User $user): View
    {
        Gate::authorize('update', $user);

        return view('user.form', [
            'title' => 'Edit Pengguna',
            'user' => $user,
            'roles' => $this->availableRoles($request),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        Gate::authorize('update', $user);
        $validated = $this->validateUser($request, $user);

        if (blank($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('user.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        Gate::authorize('delete', $user);

        if ($request->user()->isAdmin()) {
            if ($request->user()->is($user)) {
                return back()->withErrors(['user' => 'Anda tidak dapat menghapus akun sendiri.']);
            }

            if ($user->createdOrganizations()->exists()) {
                return back()->withErrors(['user' => 'Pembuat organisasi hanya dapat dihapus oleh Superadmin.']);
            }

            if ($request->user()->organization->admins()->count() <= 1) {
                return back()->withErrors(['user' => 'Organisasi harus memiliki minimal satu Admin.']);
            }
        }

        $user->delete();

        return redirect()->route('user.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    /** @return array<string, mixed> */
    private function validateUser(Request $request, ?User $user = null, bool $passwordRequired = false): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($user)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user)],
            'role' => ['required', Rule::in(array_map(fn (Role $role) => $role->value, $this->availableRoles($request)))],
            'password' => [$passwordRequired ? 'required' : 'nullable', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /** @return array<int, Role> */
    private function availableRoles(Request $request): array
    {
        return $request->user()->isSuperadmin() ? Role::cases() : [Role::Admin];
    }

    private function deletionWarning(User $user, bool $includeGlobalImpact): string
    {
        $impact = ["Hapus pengguna {$user->name}?"];

        if (! $includeGlobalImpact) {
            return implode("\n", $impact);
        }

        foreach ($user->createdOrganizations as $organization) {
            $impact[] = "\nOrganisasi \"{$organization->name}\" ikut terhapus, termasuk:";
            $impact[] = "- {$organization->categories_count} kategori";
            $impact[] = "- {$organization->reports_count} laporan beserta foto, hasil AI, dan riwayat status";
            $apiKeyNames = $organization->aiApiKeys->pluck('name')->implode(', ');
            $impact[] = '- API key: '.($apiKeyNames ?: 'tidak ada');
        }

        if ($user->reports_count > 0) {
            $impact[] = "\n- {$user->reports_count} laporan yang dikirim tetap ada, tetapi data akun pelapor akan dikosongkan";
        }

        if ($user->verified_reports_count > 0) {
            $impact[] = "- {$user->verified_reports_count} laporan terverifikasi tetap ada, tetapi data verifikator akan dikosongkan";
        }

        if ($user->status_changes_count > 0) {
            $impact[] = "- {$user->status_changes_count} riwayat status tetap ada, tetapi data pengubah akan dikosongkan";
        }

        return implode("\n", $impact);
    }
}
