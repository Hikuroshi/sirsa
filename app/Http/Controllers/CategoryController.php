<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Organization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorizeManagement($request);
        $categories = Category::query()
            ->with('organization')
            ->withCount('reports')
            ->when($request->user()->isAdmin(), fn ($query) => $query->where('organization_id', $request->user()->organization_id))
            ->latest()
            ->paginate(15);

        return view('category.index', compact('categories'));
    }

    public function create(Request $request): View
    {
        $this->authorizeManagement($request);

        return view('category.form', [
            'title' => 'Tambah Kategori',
            'organizations' => $request->user()->isSuperadmin()
                ? Organization::query()->orderBy('name')->get()
                : collect(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeManagement($request);
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
        $this->authorizeCategory($request, $category);
        $category->load('organization')->loadCount('reports');

        return view('category.show', compact('category'));
    }

    public function edit(Request $request, Category $category): View
    {
        $this->authorizeCategory($request, $category);
        $category->load('organization');

        return view('category.form', [
            'title' => 'Edit Kategori',
            'category' => $category,
            'organizations' => collect(),
        ]);
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $this->authorizeCategory($request, $category);
        $validated = $this->validateCategory($request, $category->organization, $category);
        $category->update([
            ...$validated,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Request $request, Category $category): RedirectResponse
    {
        $this->authorizeCategory($request, $category);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }

    private function authorizeManagement(Request $request): void
    {
        abort_unless(
            $request->user()->isSuperadmin()
                || ($request->user()->isAdmin() && $request->user()->organization_id !== null),
            403,
        );
    }

    private function authorizeCategory(Request $request, Category $category): void
    {
        $this->authorizeManagement($request);
        abort_unless(
            $request->user()->isSuperadmin()
                || $request->user()->organization_id === $category->organization_id,
            404,
        );
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
