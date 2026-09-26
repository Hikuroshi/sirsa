<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrganizationController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        Gate::authorize('viewAny', Organization::class);

        if ($request->user()->isAdmin()) {
            return $request->user()->organization_id === null
                ? redirect()->route('organizations.create')
                : redirect()->route('organizations.show', $request->user()->organization_id);
        }

        $organizations = Organization::query()
            ->withCount(['admins', 'categories', 'reports', 'aiApiKeys'])
            ->latest()
            ->paginate(15);
        $deletionWarnings = $organizations->getCollection()->mapWithKeys(fn (Organization $organization): array => [
            $organization->id => $this->deletionWarning($organization),
        ]);

        return view('organization.index', compact('organizations', 'deletionWarnings'));
    }

    public function create(): View
    {
        Gate::authorize('create', Organization::class);

        return view('organization.form');
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', Organization::class);
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'alpha_dash', 'max:100', 'unique:organizations,slug'],
            'description' => ['nullable', 'string', 'max:2000'],
            'is_active' => ['boolean'],
        ]);

        $organization = DB::transaction(function () use ($request, $validated): Organization {
            $organization = Organization::create([
                ...$validated,
                'created_by' => $request->user()->id,
                'is_active' => $request->boolean('is_active'),
            ]);

            if ($request->user()->isAdmin()) {
                $request->user()->update(['organization_id' => $organization->id]);
            }

            return $organization;
        });

        return redirect()->route('organizations.show', $organization)->with('success', 'Organisasi berhasil dibuat.');
    }

    public function show(Organization $organization): View
    {
        abort_unless(Gate::allows('view', $organization), 404);
        $organization->load('creator')->loadCount(['admins', 'categories', 'reports', 'aiApiKeys']);

        return view('organization.show', compact('organization'));
    }

    public function edit(Organization $organization): View
    {
        abort_unless(Gate::allows('update', $organization), 404);

        return view('organization.form', compact('organization'));
    }

    public function update(Request $request, Organization $organization): RedirectResponse
    {
        abort_unless(Gate::allows('update', $organization), 404);
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'alpha_dash', 'max:100', Rule::unique('organizations')->ignore($organization)],
            'description' => ['nullable', 'string', 'max:2000'],
            'is_active' => ['boolean'],
        ]);
        $organization->update([...$validated, 'is_active' => $request->boolean('is_active')]);

        return redirect()->route('organizations.show', $organization)->with('success', 'Organisasi berhasil diperbarui.');
    }

    public function destroy(Organization $organization): RedirectResponse
    {
        Gate::authorize('delete', $organization);
        $organization->delete();

        return redirect()->route('organizations.index')->with('success', 'Organisasi berhasil dihapus.');
    }

    private function deletionWarning(Organization $organization): string
    {
        return implode("\n", [
            "Hapus organisasi {$organization->name}?",
            'Data terkait yang ikut dihapus:',
            "- {$organization->admins_count} Admin akan dilepas dari organisasi",
            "- {$organization->categories_count} kategori",
            "- {$organization->reports_count} laporan beserta foto, hasil AI, dan riwayat status",
            "- {$organization->ai_api_keys_count} API key organisasi",
        ]);
    }
}
