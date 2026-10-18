<x-layouts.app>
    <x-slot:title>Beranda</x-slot:title>

    @include('pages.home.hero')
    @include('pages.home.tracker')
    @include('pages.home.feed')
    @include('pages.home.modal')
    @include('pages.home.dock')
    @include('pages.home.scripts')
</x-layouts.app>
