<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="sm:px-6 bg-gray-200 lg:px-8 sm:py-6 lg:py-8 py-4 px-0">
        @cannot('reference-enterprise')
        @livewire('enterprise.create-new-enterprise')
        @endcannot

        @can('reference-enterprise')
        {{-- @cannot('manage-enterprise', Auth::user()->isManager->enterprises->first()) --}}
       {{-- @livewire('product.modify-product-data', ['product' =>
        Auth::user()->isManager->enterprises()->find(2)->products->first()]) --}}
        @livewire('product.create-new-product', ['enterprise' => Auth::user()->isManager->enterprises()->find(2)])
        {{-- @endcannot --}}
        @endcan
    </div>
</x-app-layout>
