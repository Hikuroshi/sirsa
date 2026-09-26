<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Organization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Category::class);
        $categories = Category::query()
            ->with('organization')
            ->withCount('reports')
            ->when($request->user()->isAdmin(), fn ($query) => $query->where('organization_id', $request->user()->organization_id))
            ->latest()
            ->paginate(15);

        return view('category.index', [
            'title' => 'Daftar Kategori',
            'categories' => $categories,
        ]);
    }

    public function create(Request $request): View
    {
        Gate::authorize('create', Category::class);

        return view('category.form', [
            'title' => 'Tambah Kategori',
            'organizations' => $request->user()->isSuperadmin()
                ? Organization::query()->orderBy('name')->get()
                : collect(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', Category::class);
        $organization = $this->organizationForCreation($request);
        $validated = $this->validateCategory($request, $organization);

        $organization->categories()->create([
            ...$validated,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dibuat.');
    }

    public function show(Request $request, Category $category): View
    {
        Gate::authorize('view', $category);
        $category->load('organization')->loadCount('reports');

        return view('category.show', [
            'title' => 'Detail Kategori',
            'category' => $category,
        ]);
    }

    public function edit(Request $request, Category $category): View
    {
        Gate::authorize('update', $category);
        $category->load('organization');

        return view('category.form', [
            'title' => 'Edit Kategori',
            'category' => $category,
            'organizations' => collect(),
        ]);
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        Gate::authorize('update', $category);
        $validated = $this->validateCategory($request, $category->organization, $category);
        $category->update([
            ...$validated,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Request $request, Category $category): RedirectResponse
    {
        Gate::authorize('delete', $category);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }

    private function organizationForCreation(Request $request): Organization
    {
        if ($request->user()->isAdmin()) {
            return $request->user()->organization;
        }

        $validated = $request->validate([
            'organization_id' => ['required', 'uuid', Rule::exists('organizations', 'id')],
        ]);

        return Organization::query()->findOrFail($validated['organization_id']);
    }

    /** @return array<string, mixed> */
    private function validateCategory(Request $request, Organization $organization, ?Category $category = null): array
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categories')->where('organization_id', $organization->id)->ignore($category),
            ],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['boolean'],
        ]);
    }
}
