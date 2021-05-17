<x-business-layout>
    <x-buy.market-place />
    <div class="bg-gray-300">
        <x-buy.shopping.wares-listing :wares="$wares" />
    </div>

    @if($wares->count() < 1) <div class="p-4">
        <div class="flex items-center justify-center">
            <i style="font-size: 6rem;" class="text-blue-700 fas fa-shopping-bag"></i>
        </div>
        <div class="mt-4 text-lg font-semibold text-center text-blue-700">
            no wares to display.
        </div>
        </div>
        @endif

        <div class="mx-2 mb-2 md:mx-0">
            <x-paginator :data="$wares" />
        </div>
</x-business-layout>
