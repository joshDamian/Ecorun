<div>
    <div style="width: 100%;" wire:loading>
        <x-loader />
    </div>
    <div>
        @if($active_product)
        <div class="mb-4 ml-4 sm:ml-0">
            <x-jet-button wire:click="viewAll">
                <i class="fas fa-arrow-circle-left"></i> &nbsp; {{ __('All products') }}
            </x-jet-button>
        </div>
        <div>
            @livewire('product.modify-product-data', ['product' => $active_product])
        </div>
        @else
        <div x-data x-init="() => { window.scrollTo(0, 0); }" class="px-2 sm:px-0 
    @if ($products->count() < 2)
        flex justify-center items-center
    @else
        grid gap-1 grid-cols-2 sm:grid-cols-3 md:grid-cols-6
    @endif
    ">
            @forelse ($products as $product)
            <div wire:click="switchActiveProduct('{{ $product->id }}')" class="bg-white shadow py-3 px-3 cursor-pointer">
                <div class="flex items-center justify-center">
                    <img src="/storage/{{ $product->displayImage() }}" width="110" height="110" />
                </div>
                <div class="text-center pt-2">
                    <div class="truncate">
                        {{ $product->name }}
                    </div>
                    <div class="truncate">
                        {!! $product->price() !!}
                    </div>
                </div>
                @if ($product->is_published)
                <div class="text-green-700 text-center py-1 px-1">
                    <i class="fa fa-check-circle"></i> published
                </div>
                @else
                <div class="text-red-700 text-center py-1 px-1">
                    <i class="fa fa-exclamation-triangle"></i> unpublished
                </div>
                @endif
            </div>

            @empty
            <div>
                <div class="flex justify-center">
                    <i style="font-size: 8rem;" class="fas text-blue-700 fa-shopping-bag"></i>
                </div>
                <div class="text-center py-4 px-4 text-blue-700 text-lg font-bold">
                    nothing here, add a product
                </div>
            </div>
            @endforelse
        </div>
        @if($products->links()->paginator->hasPages())
        <div class="pt-2 sm:px-0 px-4">
            {{ $products->links() }}
        </div>
        @endif
    </div>
    @endif
</div>
