<x-layouts.app>
    <x-slot:title>
        Beranda
    </x-slot:title>

    <div class="pb-16 md:pb-0">
        @include ('pages.home.hero')
        @include ('pages.home.tracker')
        @include ('pages.home.feed')
        @include ('pages.home.modal')
        @include ('pages.home.dock')
        @include ('pages.home.scripts')
    </div>
</x-layouts.app>
