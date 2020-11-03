<x-app-layout>
    <x-landing-page>
        @can('view', $product)
        <div class="grid grid-cols-1 md:grid-cols-1 gap-3">
            <div class="bg-white shadow">
                <div x-data="{ activeImage: null }" x-init="() => { activeImage = '{{ $product->displayImage() }}';  }" class="grid grid-cols-1 sm:gap-3 sm:grid-cols-2">
                    <div>
                        <img :src="'/storage/' + activeImage" />
                    </div>
                    <div class="sm:pr-3 sm:py-3">
                        <div>
                            <div class="grid grid-cols-4 sm:grid-cols-2 md:grid-cols-4 bg-white sm:py-0 py-3 sm:px-0 px-3 gap-3">
                                @foreach($product->gallery as $image)
                                <div>
                                    <img class="cursor-pointer" @click=" activeImage = '{{ $image->image_url }}' " :class="('{{ $image->image_url }}' === activeImage) ? 'border-2 border-green-400' : ''" src="/storage/{{ $image->image_url }}" />
                                </div>
                                @endforeach
                            </div>
                            <div class="hidden md:block">
                                <x-product.product-data :product="$product" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:hidden sm:mt-3 md:mt-0 pb-3 px-3">
                    <x-product.product-data :product="$product" />
                </div>
            </div>
            <div>
                @livewire('user-components.product.related-by-category', ['product' => $product->id])
            </div>
        </div>
        <div class="mt-3 grid grid-cols-1 gap-3">
            <div>
                @livewire('user-components.product.enterprise-products', ['product' => $product->id])
            </div>
            @can('displayHistory', $product)
            <div>
                @livewire('user-components.product.recently-viewed', ['product' => $product->id])
            </div>
            @endcan
        </div>
        @endcan
    </x-landing-page>
</x-app-layout>
