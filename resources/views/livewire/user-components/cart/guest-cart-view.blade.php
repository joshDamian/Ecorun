<div>
    <div class="text-left bg-gray-300 p-2 grid grid-cols-1 gap-2 sm:gap-2 sm:grid-cols-2">
        @foreach($products as $product)
        <div class="grid bg-white shadow grid-cols-2">
            <div class="p-2">
                <img src="/storage/{{ $product->displayImage() }}" />
            </div>
            <div class="p-2 grid grid-cols-1 gap-2">
                <div>
                    {{ $product->name }}
                </div>
                <div>
                    {!! $product->price() !!}
                </div>
                <div>
                    @livewire('user-components.cart.manage-guest-cart-item', ['cart_item' => $cart_items[$product->id]], key(md5($loop->index.mt_rand(1000, 10000))))
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <x-paginator :data="$products" />
</div>
