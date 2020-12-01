<div>
    <div class="grid grid-cols-1 gap-3 p-3 text-left bg-gray-200 sm:gap-2 sm:grid-cols-2">
        @foreach($products as $product)
        <div class="grid grid-cols-2 bg-white shadow">
            <div class="p-2">
                <img src="/storage/{{ $product->displayImage() }}" style="width: 100%; height: 100%;" />
            </div>
            <div class="grid grid-cols-1 gap-2 p-2">
                <div>
                    {{ $product->name }}
                </div>
                <div>
                    {!! $product->price() !!}
                </div>
                <div>
                    @livewire('buy.cart.manage-guest-cart-item', ['cart_item' => $cart_items[$product->id]], key('guest_cart_item_'.$loop->index))
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <x-paginator :data="$products" />
</div>
