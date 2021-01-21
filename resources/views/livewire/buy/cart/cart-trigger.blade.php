<div>
    @if($this->existing())
    <div>
        <x-jet-button class="items-center bg-blue-600">
            <i class="far fa-eye"></i>&nbsp; view in cart
        </x-jet-button>
    </div>
    @else
    <div>
        <button onclick="Livewire.emit('receiveCartItem', '{{ $product->id }}')"
            class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-blue-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25">
            Add to cart &nbsp;<i class="fas fa-cart-plus"></i>
        </button>
    </div>
    @endif
</div>
