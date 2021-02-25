@props(['cartItems', 'view' => 'cart.page'])
<div>
    <div class="sticky flex items-center justify-between px-3 py-2 font-bold text-blue-700 bg-white top-12">
        <div class="text-lg">
            @if($view === 'cart.page')
            <i class="fas fa-shopping-cart"></i> Cart.
            @else
            <a href="{{ route('cart.index') }}">
                <i class="fas fa-chevron-left"></i>
                <i class="fas fa-shopping-cart"></i> Cart.
            </a>
            @endif
        </div>
        {{-- @if($cartItems->count() > 0)
        @if($view === 'cart.page')
        <a href="{{ route('order.preview_order') }}">
        <x-jet-button class="py-2 bg-green-500">place an order &nbsp; <i class="fas fa-chevron-right"></i>
        </x-jet-button>
        </a>
        @else
        <a href="{{ route('shop.index') }}">
            <x-jet-button class="bg-blue-700">continue shopping</x-jet-button>
        </a>
        @endif
        @endif --}}
    </div>

    <!-- Purchase policy -->
    @if($view === 'place_order.page')
    <div class="px-2 py-2">
        @include('policies.purchase-policy')
    </div>
    @endif

    @if($view === 'place_order.page')
    <div class="p-3 bg-gray-100">
        Items to be ordered:
    </div>
    @endif

    <div class="grid grid-cols-1 gap-2 px-2 py-2 bg-gray-300 md:px-0">
        @forelse($cartItems as $key => $cartItem)
        <div>
            <x-buy.cart.cart-item :view="$view" :cartItem="$cartItem" />
        </div>
        @empty
        <div class="p-5 bg-gray-100">
            <div class="flex items-center justify-center text-blue-700">
                <i style="font-size: 5rem;" class="fas fa-shopping-cart"></i>
            </div>

            <div class="mt-4 text-xl font-bold text-center text-blue-700">
                your cart is empty.
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('shop.index') }}">
                    <x-jet-button class="bg-blue-700">
                        shop
                    </x-jet-button>
                </a>
            </div>
        </div>
        @endforelse
    </div>

    @if($cartItems->count() > 0)
    <div class="sticky bottom-0 flex flex-wrap items-center justify-center px-3 py-3 bg-gray-200 sm:px-5">
        @if($view === 'cart.page')
        <a href="{{ route('shop.index') }}">
            <x-jet-button class="bg-blue-700">continue shopping</x-jet-button>
        </a>
        @else
        <a href="{{ route('order.place_order') }}">
            <x-jet-button class="py-2 bg-green-500">complete order</x-jet-button>
        </a>
        @endif
    </div>
    @endif

    @if($view === 'cart.page')
    @if($this->itemToDelete)
    <div>
        <x-jet-confirmation-modal wire:model="confirmDelete">
            <x-slot name="title">
                <div class="text-left">
                    {{ __('Remove Cart Item') }}
                </div>
            </x-slot>

            <x-slot name="content">
                <div class="text-left">
                    Do you want to remove this item from your cart?
                </div>
            </x-slot>

            <x-slot name="footer">
                <div>
                    <x-jet-secondary-button wire:click="cancelDelete" class="mr-4">
                        {{ __('cancel') }}
                    </x-jet-secondary-button>
                    <x-jet-danger-button wire:click="delete">
                        {{ __('Remove') }}
                    </x-jet-danger-button>
                </div>
            </x-slot>
        </x-jet-confirmation-modal>
    </div>
    @endif

    @if($this->itemToEdit)
    <div>
        @auth
        <div>
            @livewire('buy.cart.manage-auth-cart-item', ['cartItem' => $this->itemToEdit, 'confirm' => true])
        </div>
        @endauth
        @guest
        <div>
            @livewire('buy.cart.manage-guest-cart-item', ['cartItem' =>
            session()->get('guest_cart_store')[$this->itemToEdit], 'confirm' => true])
        </div>
        @endguest
    </div>
    @endif
    @endif
</div>
