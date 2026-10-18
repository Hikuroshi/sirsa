<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-page-header :title="$title" />

    <div class="card bg-base-100 mt-6 shadow-sm">
        <div class="card-body">
            <form
                action="{{ isset($category) ? route('categories.update', $category) : route('categories.store') }}"
                method="POST"
            >
                @csrf
                @isset($category)
                    @method('PUT')
                @endisset

                <x-form.input label="Nama" name="name" :value="$category->name ?? ''" />
                <x-form.textarea label="Deskripsi" name="description" :value="$category->description ?? ''" />

                <div class="card-actions mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-ghost">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
