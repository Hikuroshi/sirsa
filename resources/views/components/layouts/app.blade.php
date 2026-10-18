<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="winter">
<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>{{ $title }} | {{ config('app.name') }}</title>

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen">
    <div class="navbar bg-base-100 shadow-sm sticky top-0 z-50">
        <div class="mx-auto w-full max-w-6xl px-4">
            <div class="flex w-full items-center">
                {{-- Mobile hamburger --}}
                <div class="flex-none lg:hidden">
                    <details class="dropdown">
                        <summary class="btn btn-square btn-ghost btn-sm" aria-label="Menu">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="h-5 w-5 stroke-current">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </summary>
                        <ul class="menu dropdown-content bg-base-100 rounded-box z-50 mt-2 w-56 p-2 shadow-lg">
                            @auth
                                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a href="{{ route('reports.index') }}">Laporan</a></li>
                                <li><a href="{{ route('public-reports.create') }}">Buat Laporan</a></li>
                                @can('viewAny', App\Models\User::class)
                                    <li><a href="{{ route('user.index') }}">Pengguna</a></li>
                                @endcan
                                @can('viewAny', App\Models\Category::class)
                                    <li><a href="{{ route('categories.index') }}">Kategori</a></li>
                                @endcan
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full text-left text-error">Logout</button>
                                    </form>
                                </li>
                            @else
                                <li><a href="{{ route('public-reports.create') }}">Buat Laporan</a></li>
                                <li><a href="{{ route('login') }}">Login</a></li>
                                <li><a href="{{ route('register') }}">Register</a></li>
                            @endauth
                        </ul>
                    </details>
                </div>

                {{-- Logo --}}
                <div class="flex-1 lg:flex-none">
                    <a href="{{ route('home') }}" class="btn btn-ghost text-base font-bold">
                        {{ config('app.name') }}
                    </a>
                </div>

                {{-- Desktop nav links --}}
                <div class="navbar-center hidden flex-1 lg:flex">
                    <ul class="menu menu-horizontal gap-1 px-1 text-sm">
                        @auth
                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li><a href="{{ route('reports.index') }}">Laporan</a></li>
                            <li><a href="{{ route('public-reports.create') }}">Buat Laporan</a></li>
                            @can('viewAny', App\Models\User::class)
                                <li><a href="{{ route('user.index') }}">Pengguna</a></li>
                            @endcan
                            @can('viewAny', App\Models\Category::class)
                                <li><a href="{{ route('categories.index') }}">Kategori</a></li>
                            @endcan
                        @else
                            <li><a href="{{ route('public-reports.create') }}">Buat Laporan</a></li>
                        @endauth
                    </ul>
                </div>

                {{-- Desktop right actions --}}
                <div class="hidden lg:flex lg:flex-none items-center gap-2">
                    @auth
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-ghost btn-sm text-error">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <main class="mx-auto max-w-6xl px-4 py-8">
        @if (session('success'))
            <div role="alert" class="alert alert-success mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        {{ $slot }}
    </main>
</body>
</html>

