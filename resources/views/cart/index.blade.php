<x-business-layout>
    <div class="sticky px-3 py-2 font-bold text-blue-700 bg-white top-12">
        Cart.
    </div>

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
