<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
            ->withCount('reports')
            ->search($request->string('search')->trim()->toString())
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('category.index', [
            'title' => 'Daftar Kategori',
            'categories' => $categories,
        ]);
    }

    public function create(): View
    {
        Gate::authorize('create', Category::class);

        return view('category.form', [
            'title' => 'Tambah Kategori',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', Category::class);
        $validated = $this->validateCategory($request);

        Category::create([
            ...$validated,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dibuat.');
    }

    public function show(Category $category): View
    {
        Gate::authorize('view', $category);
        $category->loadCount('reports');

        return view('category.show', [
            'title' => 'Detail Kategori',
            'category' => $category,
        ]);
    }

    public function edit(Category $category): View
    {
        Gate::authorize('update', $category);

        return view('category.form', [
            'title' => 'Edit Kategori',
            'category' => $category,
        ]);
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        Gate::authorize('update', $category);
        $validated = $this->validateCategory($request, $category);
        $category->update([
            ...$validated,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        Gate::authorize('delete', $category);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }

    /** @return array<string, mixed> */
    private function validateCategory(Request $request, ?Category $category = null): array
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categories')->ignore($category),
            ],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['boolean'],
        ]);
    }
}
