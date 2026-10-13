<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>{{ $title }} | {{ config('app.name') }}</title>

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900">
    <nav class="border-b bg-white">
        <div class="mx-auto flex max-w-6xl flex-col gap-3 p-4 sm:flex-row sm:items-center sm:justify-between">
            <a class="font-semibold" href="{{ route('home') }}">{{ config('app.name') }}</a>
            <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm sm:justify-end">
                @auth
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <a href="{{ route('reports.index') }}">Laporan</a>
                    <a href="{{ route('public-reports.create') }}">Buat Laporan</a>
                    @can('viewAny', App\Models\User::class)
                        <a href="{{ route('user.index') }}">Pengguna</a>
                    @endcan
                    @can('viewAny', App\Models\Category::class)
                        <a href="{{ route('categories.index') }}">Kategori</a>
                    @endcan
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                @else
                    <a href="{{ route('public-reports.create') }}">Buat Laporan</a>
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
