<div>
    @if($view === 'feed')
    @if($this->existing())
    <div
        class="flex items-center justify-center px-3 py-2 font-bold text-center text-blue-700 bg-white rounded-full cursor-pointer">
        <i class="text-xl text-blue-700 far fa-eye"></i> <span class="hidden sm:inline">&nbsp; View in cart</span>
    </div>
    @else
    <div onclick="Livewire.emit('receiveCartItem', '{{ $product->id }}')"
        class="flex items-center justify-center px-3 py-2 font-bold text-center text-blue-700 bg-white rounded-full cursor-pointer">
        <i class="text-xl text-blue-700 fas fa-cart-plus"></i> <span class="hidden sm:inline">&nbsp; Add to cart</span>
    </div>
    @endif

    @else
    @if($this->existing())
    <div>
        <a {{-- href="{{ route('cart.index') }}" --}}>
            <x-jet-button class="items-center bg-blue-600">
                <i class="far fa-eye"></i>&nbsp; view in cart
            </x-jet-button>
        </a>
    </div>
    @else
    <div>
        <button onclick="Livewire.emit('receiveCartItem', '{{ $product->id }}')"
            class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-blue-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25">
            Add to cart &nbsp;<i class="fas fa-cart-plus"></i>
        </button>
    </div>
    @endif
    @endif
</div>