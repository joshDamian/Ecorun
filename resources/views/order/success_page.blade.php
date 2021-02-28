<x-business-layout>
    <div class="p-4 bg-gray-100">
        <h3 class="px-4 py-3 text-xl font-semibold text-center text-green-500 border border-green-500 rounded-md">
            You have successfully placed your order.
        </h3>

        <div class="px-4 py-3 mt-4 border-t border-b border-gray-300">
            <div class="font-semibold text-gray-700">
                Tracking ID:
                <span class="px-2 py-1 m-2 text-green-500 border-2 border-green-500 rounded-2xl">
                    {{ $order->tracking_id }}
                </span>
            </div>

            <div class="">

            </div>
        </div>
    </div>
</x-business-layout>
