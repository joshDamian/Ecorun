<div>
    <div class="sm:pt-6 bg-gray-800 pt-13 px-4 mt-12 md:mt-2 pb-4 md:pb-5">
        <div class="grid grid-cols-1 gap-4">
            <!-- Billboard -->
            {{-- <div>
                <div class="bg-white py-4 flex justify-center shadow items-center">
                    <i style="font-size: 10rem;" class="fas text-blue-800 fa-clipboard-list"></i>
                </div>
            </div>
            --}}

            <!-- Store Products -->
            <div>
                <div class="mb-2 text-green-200 font-bold text-lg">
                    {{ __('Latest on product sales!') }}
                </div>
                @livewire('user-components.product.store-product-list')
            </div>

            <div>
                <div class="mb-2 text-green-200 font-bold text-lg">
                    {{ __('Latest on services!') }}
                </div>
                @livewire('user-components.product.service-product-list')
            </div>
        </div>
    </div>
</div>