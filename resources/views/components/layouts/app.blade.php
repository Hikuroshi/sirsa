<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>{{ $title }} | {{ config('app.name', 'SIRSA') }}</title>

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900">
    <nav class="border-b bg-white">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 p-4">
            <a class="font-semibold" href="{{ route('home') }}">SIRSA</a>
            <div class="flex items-center gap-4 text-sm">
                @auth
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <a href="{{ route('reports.index') }}">Laporan</a>
                    @if (auth()->user()->isAdmin() || auth()->user()->isSuperadmin())
                        <a href="{{ route('organizations.index') }}">Organisasi</a>
                    @endif
                    @if (auth()->user()->isAdmin() && auth()->user()->organization_id !== null)
                        <a href="{{ route('user.index') }}">Admin</a>
                        <a href="{{ route('categories.index') }}">Kategori</a>
                        <a href="{{ route('ai-keys.index') }}">API Key</a>
                    @endif
                    @if (auth()->user()->isSuperadmin())
                        <a href="{{ route('categories.index') }}">Kategori</a>
                        <a href="{{ route('ai-keys.index') }}">API Key</a>
                        <a href="{{ route('ai-model-limits.index') }}">Model AI</a>
                        <a href="{{ route('user.index') }}">Pengguna</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>
    </nav>
    <main class="mx-auto max-w-6xl p-6">
        @if (session('success'))
            <x-alert class="mb-4">{{ session('success') }}</x-alert>
        @endif
        {{ $slot }}
    </main>
</body>
</html>
