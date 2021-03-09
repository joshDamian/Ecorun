<x-business-layout>
    <div class="p-4 bg-gray-100">
        <h3 class="px-4 py-3 sm:text-xl font-semibold text-center text-green-500 border border-green-500 rounded-md">
            You have successfully placed your order.
        </h3>

        <div class="py-3 mt-4 border-t border-b border-gray-300">
            <div class="font-semibold text-gray-700">
                Tracking ID:
                <span class="px-2 py-1 m-2 text-green-500 border-2 border-green-500 rounded-2xl">
                    {{ $order->tracking_id }}
                </span>
            </div>

            <div class="font-semibold text-gray-600">
                Items:
            </div>

            <div class="grid grid-cols-1 gap-0.5">
                @foreach($order->products as $item)
                <div class="bg-white flex p-2">
                    <div style="background-image: url('/storage/{{ $item->gallery->first()->image_url }}'); background-size: cover; background-position: center center;"
                        class="flex-shrink-0 w-24 h-24 mr-4 sm:w-28 sm:h-28 md:mr-8">
                    </div>

                    <div class="flex-1 gap-0.5 grid grid-cols-1">
                        <div class="font-bold">
                            {{ $item->name }}
                        </div>
                        <div class="font-semibold text-gray-700">
                            vendor:
                            <a href="{{ $item->business->profile->url->visit }}">
                                {{ $item->business->profile->name }}
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-business-layout>