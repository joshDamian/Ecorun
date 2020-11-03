<div class="inline" wire:click="$emit('expand_cart')">
    @switch($view)
    @case('icon+counter')
    <span class="font-semibold cursor-pointer text-blue-700">
        <i class="fas fa-shopping-cart"></i> Cart (@livewire('user-components.cart.cart-counter', key('cart_counter'.time())))
    </span>
    @break
    @case('button')
    <x-jet-button class="bg-blue-600 font-bold">
        {{ __('view in cart') }} &nbsp;<i class="fas fa-eye"></i>
    </x-jet-button>
    @break
    @default

    @endswitch
</div>
