<div>
    <div class="text-left bg-gray-200 p-3 grid grid-cols-1 gap-3 sm:gap-2 sm:grid-cols-2">
        @foreach($products as $product)
        <div class="grid bg-white shadow grid-cols-2">
            <div class="p-2">
                <img src="/storage/{{ $product->displayImage() }}" style="width: 100%; height: 100%;" />
            </div>
            <div class="p-2 grid grid-cols-1 gap-2">
                <div>
                    {{ $product->name }}
                </div>
                <div>
                    {!! $product->price() !!}
                </div>
                <div>
                    @livewire('user-components.cart.manage-guest-cart-item', ['cart_item' => $cart_items[$product->id]], key('guest_cart_item_'.$loop->index))
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <x-paginator :data="$products" />
</div>
