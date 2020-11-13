<div class="sm:pt-12 md:pt-4 relative bg-gray-100 pt-12 sm:px-2 px-0 mt-12 md:mt-2 pb-2 md:pb-2">
    <div x-data="{show: false}" class="sm:flex sm:justify-center" x-cloak>
        <div class="mb-1 sm:mb-0 sm:relative shadow select-none mx-1 sm:mt-0 sm:mx-0 bg-white sm:mr-2">
            <div :class="{'border-gray-200 border-b-2' : show }" class="flex sm:hidden py-3 px-3 justify-between overflow-x-scroll relative">
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
            </div>
            <div x-show="show" class="bg-white py-3">
                <x-category.category-listing />
            </div>
            <div class="hidden sticky md:top-15 sm:top-24 bg-white sm:block">

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
        <div class="flex-1 @if(! request()->routeIs('product.show')) px-2 md:px-0 @endif">
            <div>
                @livewire('user-components.cart.view-cart', key('cart_view'))
            </div>
            {{ $slot }}
        </div>
    </div>
</div>
