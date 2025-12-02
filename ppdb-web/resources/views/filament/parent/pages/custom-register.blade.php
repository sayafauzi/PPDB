<x-filament-panels::page.simple>
    <x-slot name="heading">
        Register Akun Orang Tua
    </x-slot>

    <form wire:submit.prevent="register">
        {{ $this->form }}
    </form>
    

    <div class="mt-4 text-center">
        <a href="{{ filament()->getLoginUrl() }}" class="text-primary-600">
            Sudah punya akun? Masuk
        </a>
    </div>
</x-filament-panels::page.simple>
