<div>
    @if($active_product)
    <div class="mb-4 ml-4 sm:ml-0">
        <x-jet-button wire:click="viewAll">
            {{ __('<< All products') }}
        </x-jet-button>
</div>
    <div>
        @livewire('product.modify-product-data', ['product' => $active_product])
    </div>
    @else
    <div class="grid gap-3 px-4 sm:px-0 grid-cols-2 sm:grid-cols-5">
        @foreach ($products as $product)
        <div wire:click="switchActiveProduct('{{ $product->id }}')" class="bg-white shadow cursor-pointer">
            <img src="/storage/{{ $product->displayImage() }}" width="200" height="200" />
            <div class="py-2 px-2 text-center truncate">
                <div>
                    {{ $product->name}}
                </div>
                <div>
                    <span>&#8358;</span> {{ number_format($product->price, 2) }}
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>