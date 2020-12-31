<div>
    <div class="w-full" wire:loading>
        <x-loader_2 />
    </div>
    <div>
        @if($active_product)
        <div class="mb-4 ml-4 sm:ml-0">
            <x-jet-button wire:click="viewAll">
                <i class="fas fa-arrow-circle-left"></i> &nbsp; {{ __('All products') }}
            </x-jet-button>
        </div>

        <div>
            @livewire('build-and-manage.product.product-dashboard', ['product' => $active_product])
        </div>

        @else
        <div x-data x-init="() => { window.scrollTo(0, 0); }" class="@if($business->products_count > 0) grid gap-2 sm:gap-2 grid-cols-2 sm:grid-cols-3 md:grid-cols-6 @endif px-2 sm:px-0">
            @forelse ($products as $product)
            <div wire:click="switchActiveProduct('{{ $product->id }}')" class="px-3 py-3 bg-gray-100 cursor-pointer">
                <div class="flex items-center justify-center">
                    <img src="/storage/{{ $product->displayImage() }}" width="150" height="150" />
                </div>

                <div class="pt-2 text-center">
                    <div class="truncate">
                        {{ $product->name }}
                    </div>

                    <div class="truncate">
                        {!! $product->price() !!}
                    </div>
                </div>

                @if ($product->is_published)
                <div class="px-1 py-1 text-center text-green-700">
                    <i class="fa fa-check-circle"></i> published
                </div>

                @else
                <div class="px-1 py-1 text-center text-red-700">
                    <i class="fa fa-exclamation-triangle"></i> unpublished
                </div>
                @endif
            </div>

            @empty
            <div>
                <div class="flex justify-center">
                    <i style="font-size: 8rem;" class="text-blue-700 fas fa-shopping-bag"></i>
                </div>

                <div class="px-3 py-3 text-lg font-bold text-center text-blue-700">
                    <span class="block mb-3">
                        your product store is empty.
                    </span>
                </div>
            </div>
            @endforelse
        </div>

        <div class="mx-2 md:mx-0">
            <x-paginator :data="$products" />
        </div>
    </div>
    @endif

    @if($active_product)
    <script>
        setTimeout(() => {
            window.modifyUrl.modify("/biz/{{ $business->profile->full_tag() }}/products/{{ $active_product->id }}")
        }, 100);

    </script>

    @else
    <script>
        setTimeout(() => {
            window.modifyUrl.modify("/biz/{{ $business->profile->full_tag() }}/products")
        }, 100);

    </script>
    @endif
</div>