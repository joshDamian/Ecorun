<div class="sm:pt-13 md:pt-6 relative bg-gray-300 pt-13 md:px-3 px-2 mt-12 md:mt-2 pb-2 md:pb-4">
    <div x-data="{show: false}" class="md:flex md:justify-center">
        <div class="mb-3 md:mb-0 md:relative flex-shrink-0 rounded-md md:rounded-none shadow bg-white md:mr-3">
            <div :class="{'border-gray-300 border-b-2' : show }" class="flex md:hidden py-3 px-3 justify-between overflow-x-scroll relative">
                <span @click=" show = ! show " class="font-bold sticky bg-white left-0 flex-shrink-0 truncate cursor-pointer mr-3">
                    <i :class="show ? 'fas fa-times' : 'fas fa-bars'" class="text-blue-700"></i>
                </span>
                <span class="flex-shrink-0 mr-3">
                    @livewire('user-components.cart.cart-trigger', ['view' => 'icon+counter'], key('cart_trigger_1'))
                </span>
                <span class="font-semibold flex-shrink-0 cursor-pointer mr-3 text-blue-700">
                    <a href="{{ route('view-history.index') }}">
                        <i class="fas fa-history"></i> Browsing history
                    </a>
                </span>
                <span class="font-semibold flex-shrink-0 cursor-pointer pr-3 text-blue-700">
                    <i class="fas fa-user-tie"></i> Manager Account
                </span>
            </div>
            <div x-show="show" class="bg-white py-3">
                <x-category.category-listing />
            </div>
            <div class="hidden sticky top-15 bg-white md:block">
                <div class="border-b-2 py-2 px-3  border-gray-300">
                    <a href="{{ route('dashboard') }}">
                        <span class="font-semibold cursor-pointer text-blue-700">
                            <i class="fas fa-user"></i> Dashboard
                        </span>
                    </a>
                </div>

                <div class="border-b-2 py-2 px-3  border-gray-300">
                    @livewire('user-components.cart.cart-trigger', ['view' => 'icon+counter'], key('cart_trigger_2'))
                </div>

                <div class="py-2 border-b-2 border-gray-300">
                    <x-category.category-listing />
                </div>

                <div class="py-2 px-3">
                    <a href="{{ route('view-history.index') }}">
                        <span class="font-semibold cursor-pointer text-blue-700">
                            <i class="fas fa-history"></i> Browsing history
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="flex-grow flex-shrink">
            <div>
                @livewire('user-components.cart.view-cart', key('cart_view'))
            </div>
            {{ $slot }}
        </div>
    </div>
</div>
