<x-business-layout>
    @auth
    <div>
        @livewire('buy.cart.manage-auth-cart', key("manage_cart"))
    </div>
    @endauth

    @guest
    <div>
        @livewire('buy.cart.manage-guest-cart', key("manage_cart"))
    </div>
    @endguest
</x-business-layout>