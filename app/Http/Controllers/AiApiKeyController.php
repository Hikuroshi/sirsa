<?php

namespace App\Http\Controllers;

use App\Models\AiApiKey;
use App\Models\AiModelLimit;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AiApiKeyController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', AiApiKey::class);
        $keys = AiApiKey::query()
            ->with('modelLimit')
            ->when($request->user()->isSuperadmin(), fn ($query) => $query->whereNull('organization_id'))
            ->when($request->user()->isAdmin(), fn ($query) => $query->where('organization_id', $request->user()->organization_id))
            ->orderBy('priority')
            ->paginate(15);

        return view('ai-key.index', [
            'title' => 'Daftar API Key',
            'keys' => $keys,
        ]);
    }

    public function create(Request $request): View
    {
        Gate::authorize('create', AiApiKey::class);

        return view('ai-key.form', [
            'title' => 'Tambah API Key',
            'modelLimits' => $this->modelLimits(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', AiApiKey::class);
        $validated = $this->validateKey($request, true);
        AiApiKey::create([
            ...$validated,
            'organization_id' => $request->user()->isAdmin() ? $request->user()->organization_id : null,
            'suffix' => mb_substr($validated['secret'], -4),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('ai-keys.index')->with('success', 'API key berhasil dibuat.');
    }

    public function show(Request $request, AiApiKey $aiKey): View
    {
        Gate::authorize('view', $aiKey);
        $aiKey->load(['modelLimit', 'organization']);

        return view('ai-key.show', [
            'title' => 'Detail API Key',
            'key' => $aiKey,
        ]);
    }

    public function edit(Request $request, AiApiKey $aiKey): View
    {
        Gate::authorize('update', $aiKey);
        $aiKey->load('modelLimit');

        return view('ai-key.form', [
            'title' => 'Edit API Key',
            'key' => $aiKey,
            'modelLimits' => $this->modelLimits(),
        ]);
    }

    public function update(Request $request, AiApiKey $aiKey): RedirectResponse
    {
        Gate::authorize('update', $aiKey);
        $validated = $this->validateKey($request, false);

        if (blank($validated['secret'] ?? null)) {
            unset($validated['secret']);
        } else {
            $validated['suffix'] = mb_substr($validated['secret'], -4);
        }

        $aiKey->update([...$validated, 'is_active' => $request->boolean('is_active')]);

        return redirect()->route('ai-keys.index')->with('success', 'API key berhasil diperbarui.');
    }

    public function destroy(Request $request, AiApiKey $aiKey): RedirectResponse
    {
        Gate::authorize('delete', $aiKey);
        $aiKey->delete();

        return redirect()->route('ai-keys.index')->with('success', 'API key berhasil dihapus.');
    }

    /** @return array<string, mixed> */
    private function validateKey(Request $request, bool $secretRequired): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'ai_model_limit_id' => ['required', 'uuid', Rule::exists('ai_model_limits', 'id')],
            'secret' => [$secretRequired ? 'required' : 'nullable', 'string', 'max:1000'],
            'priority' => ['required', 'integer', 'min:1', 'max:1000'],
            'is_active' => ['boolean'],
            'rpm' => ['nullable', 'integer', 'min:1'],
            'rpd' => ['nullable', 'integer', 'min:1'],
            'tpm' => ['nullable', 'integer', 'min:1'],
        ]);
    }

    private function modelLimits(): Collection
    {
        return AiModelLimit::query()->orderBy('provider')->orderBy('model')->get();
    }
}
