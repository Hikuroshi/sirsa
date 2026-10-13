<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', User::class);
        $users = User::query()
            ->search($request->string('search')->trim()->toString())
            ->latest()
            ->paginate(10)
            ->withQueryString();
        $deletionWarnings = $users->getCollection()->mapWithKeys(fn (User $user): array => [
            $user->id => "Hapus pengguna {$user->name}? Laporan dan riwayat yang terkait tetap tersimpan, tetapi referensi akun pengguna akan dikosongkan.",
        ]);

        return view('user.index', [
            'title' => 'Daftar Pengguna',
            'users' => $users,
            'deletionWarnings' => $deletionWarnings,
        ]);
    }

    public function create(): View
    {
        Gate::authorize('create', User::class);

        return view('user.form', [
            'title' => 'Tambah Pengguna',
            'roles' => Role::cases(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', User::class);
        $validated = $this->validateUser($request, passwordRequired: true);

        User::create($validated);

        return redirect()->route('user.index')->with('success', 'Pengguna berhasil dibuat.');
    }

    public function show(User $user): View
    {
        Gate::authorize('view', $user);

        return view('user.show', [
            'title' => 'Detail Pengguna',
            'user' => $user,
        ]);
    }

    public function edit(User $user): View
    {
        Gate::authorize('update', $user);

        return view('user.form', [
            'title' => 'Edit Pengguna',
            'user' => $user,
            'roles' => Role::cases(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        Gate::authorize('update', $user);
        $validated = $this->validateUser($request, $user);

        if (blank($validated['password'] ?? null)) {
            unset($validated['password']);
        }

        DB::transaction(function () use ($request, $user, $validated): void {
            $admins = User::query()->where('role', Role::Admin->value)->lockForUpdate()->get();
            $lockedUser = User::query()->lockForUpdate()->findOrFail($user->id);

            if ($lockedUser->isAdmin() && $validated['role'] !== Role::Admin->value) {
                if ($request->user()->is($user)) {
                    throw ValidationException::withMessages(['role' => 'Anda tidak dapat mengubah peran akun sendiri.']);
                }

                if ($admins->count() <= 1) {
                    throw ValidationException::withMessages(['role' => 'Aplikasi harus memiliki minimal satu pengguna pengelola.']);
                }
            }

            $lockedUser->update($validated);
        }, 3);

        return redirect()->route('user.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        Gate::authorize('delete', $user);

        if ($request->user()->is($user)) {
            return back()->withErrors(['user' => 'Anda tidak dapat menghapus akun sendiri.']);
        }

        $deleted = DB::transaction(function () use ($user): bool {
            $admins = User::query()->where('role', Role::Admin->value)->lockForUpdate()->get();
            $lockedUser = User::query()->lockForUpdate()->findOrFail($user->id);

            if ($lockedUser->isAdmin() && $admins->count() <= 1) {
                return false;
            }

            $lockedUser->delete();

            return true;
        });

        if (! $deleted) {
            return back()->withErrors(['user' => 'Aplikasi harus memiliki minimal satu pengguna pengelola.']);
        }

        return redirect()->route('user.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    /** @return array<string, mixed> */
    private function validateUser(Request $request, ?User $user = null, bool $passwordRequired = false): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($user)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user)],
            'password' => [$passwordRequired ? 'required' : 'nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::enum(Role::class)],
        ]);
    }
}
