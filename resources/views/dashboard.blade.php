<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="sm:px-6 lg:px-8 sm:py-6 lg:py-8 py-4 px-4">
        <div class="grid sm:py-4 sm:px-4  grid-cols-1 sm:grid-cols-6 gap-4">
            <div class="sm:col-span-1">
                @livewire('dashboard.action-switch')
            </div>
            <div class="sm:col-span-5">
                <div class="bg-white overflow-hidden shadow-xl">
                    @livewire('dashboard.action-view')
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        Livewire.on('dashboard_actionSwitch', (id) => {
            console.log(id);
        })

    </script>
    @endpush
</x-app-layout>
