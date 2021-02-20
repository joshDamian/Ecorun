@props(['cartItems'])
<div>
    <div class="grid grid-cols-1 gap-2 px-2 py-2 md:px-0">
        @forelse($cartItems as $key => $cartItem)
        <div>
            <x-buy.cart.cart-item :cartItem="$cartItem" />
        </div>
        @empty
        <div class="p-5">
            <div class="flex items-center justify-center text-blue-700">
                <i style="font-size: 5rem;" class="fas fa-shopping-cart"></i>
            </div>
        </div>
        @endforelse
    </div>

    <div>
        <x-jet-confirmation-modal wire:model="confirm">
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
                    <x-jet-secondary-button wire:click="cancel" class="mr-4">
                        {{ __('cancel') }}
                    </x-jet-secondary-button>
                    <x-jet-danger-button wire:click="delete">
                        {{ __('Remove') }}
                    </x-jet-danger-button>
                </div>
            </x-slot>
        </x-jet-confirmation-modal>
    </div>

    <div class="mx-2 md:mx-0">
        <x-paginator :data="$cartItems" />
    </div>
</div>
