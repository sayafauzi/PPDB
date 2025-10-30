<x-filament-panels::page>
    <div class="flex min-h-screen items-center justify-center bg-gray-50 dark:bg-gray-900 px-4">
        <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 space-y-6">

            <form wire:submit.prevent="register" class="space-y-4">
                {{ $this->form }}
            </form>
        </div>
    </div>
</x-filament-panels::page>
