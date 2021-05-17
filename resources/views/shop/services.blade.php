<x-business-layout>
    @section('shop_breadcrumb')
    <i class="flex-shrink-0 mx-2 text-gray-600 fas fa-chevron-right"></i>
    <a href="{{ route('shop.services') }}" class="flex-shrink-0 cursor-pointer hover:underline">Services</a>
    @endsection
    <x-buy.market-place />
    <div class="bg-gray-300">
        <x-buy.shopping.wares-listing :wares="$services" />
    </div>

    @if($services->count() < 1) <div class="p-4">
        <div class="flex items-center justify-center">
            <i style="font-size: 6rem;" class="text-blue-700 fas fa-shopping-bag"></i>
        </div>
        <div class="mt-4 text-lg font-semibold text-center text-blue-700">
            no services to display.
        </div>
        </div>
        @endif

        <div class="mx-2 mb-2 md:mx-0">
            <x-paginator :data="$services" />
        </div>
</x-business-layout>
