<x-layouts.app>
    <x-slot:title>Beranda</x-slot:title>

    <x-page-header :title="config('app.name')" />

    <x-card class="mt-6">
        <p>Sampaikan pengaduan Anda kepada {{ config('app.name') }} dan pantau perkembangannya dengan kode pelacakan.</p>
        <x-button class="mt-4" :href="route('public-reports.create')">Buat Laporan</x-button>
    </x-card>
</x-layouts.app>
