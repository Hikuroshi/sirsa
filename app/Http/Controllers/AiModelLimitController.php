<?php

namespace App\Http\Controllers;

use App\Models\AiModelLimit;
use App\Services\AiProviderRegistry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AiModelLimitController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', AiModelLimit::class);

        return view('ai-model-limit.index', [
            'title' => 'Daftar Model AI',
            'limits' => AiModelLimit::query()
                ->withCount('apiKeys')
                ->search($request->string('search')->trim()->toString())
                ->orderBy('provider')
                ->orderBy('model')
                ->paginate(15)
                ->withQueryString(),
        ]);
    }

    public function create(Request $request, AiProviderRegistry $providers): View
    {
        Gate::authorize('create', AiModelLimit::class);

        return view('ai-model-limit.form', [
            'title' => 'Tambah Model AI',
            'providers' => $providers->options(),
        ]);
    }

    public function store(Request $request, AiProviderRegistry $providers): RedirectResponse
    {
        Gate::authorize('create', AiModelLimit::class);
        AiModelLimit::create($this->validated($request, $providers));

        return redirect()->route('ai-model-limits.index')->with('success', 'Model AI berhasil dibuat.');
    }

    public function show(Request $request, AiModelLimit $aiModelLimit): View
    {
        Gate::authorize('view', $aiModelLimit);
        $aiModelLimit->loadCount('apiKeys');

        return view('ai-model-limit.show', [
            'title' => 'Detail Model AI',
            'limit' => $aiModelLimit,
        ]);
    }

    public function edit(Request $request, AiModelLimit $aiModelLimit, AiProviderRegistry $providers): View
    {
        Gate::authorize('update', $aiModelLimit);

        return view('ai-model-limit.form', [
            'title' => 'Edit Model AI',
            'limit' => $aiModelLimit,
            'providers' => $providers->options(),
        ]);
    }

    public function update(Request $request, AiModelLimit $aiModelLimit, AiProviderRegistry $providers): RedirectResponse
    {
        Gate::authorize('update', $aiModelLimit);
        $aiModelLimit->update($this->validated($request, $providers, $aiModelLimit));

        return redirect()->route('ai-model-limits.index')->with('success', 'Model AI berhasil diperbarui.');
    }

    public function destroy(Request $request, AiModelLimit $aiModelLimit): RedirectResponse
    {
        Gate::authorize('delete', $aiModelLimit);

        if ($aiModelLimit->apiKeys()->exists()) {
            return back()->withErrors(['model' => 'Model masih digunakan oleh API key.']);
        }

        $aiModelLimit->delete();

        return redirect()->route('ai-model-limits.index')->with('success', 'Model AI berhasil dihapus.');
    }

    /** @return array<string, mixed> */
    private function validated(Request $request, AiProviderRegistry $providers, ?AiModelLimit $limit = null): array
    {
        return $request->validate([
            'provider' => ['required', 'string', Rule::in(array_keys($providers->options()))],
            'model' => [
                'required',
                'string',
                'max:150',
                Rule::unique('ai_model_limits')->where('provider', $request->string('provider')->toString())->ignore($limit),
            ],
            'rpm' => ['required', 'integer', 'min:1'],
            'rpd' => ['required', 'integer', 'min:1'],
            'tpm' => ['required', 'integer', 'min:1'],
        ]);
    }
}
