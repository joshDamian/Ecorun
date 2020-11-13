<div>
    <div>
        <x-jet-dialog-modal padding="px-0" maxWidth="3xl" wire:model="expanded">
            <x-slot name="title">
                <div class="text-left font-bold text-blue-800">
                    {{ __('Cart') }}
                </div>
            </x-slot>

            <x-slot name="content">
                <div>
                    @if($this->count() > 0)
                    <div>
                        @auth
                        <div class="text-left bg-gray-200 p-3 grid grid-cols-1 gap-3 sm:grid-cols-2">
                            @foreach($cart_items as $item)
                            <div class="grid bg-white shadow grid-cols-2">
                                <div class="p-2 flex items-center justify-items-center justify-center">
                                    <img src="/storage/{{ $item->product->displayImage() }}" style="width: 100%; height: 100%;" />
                                </div>
                                <div class="p-2 grid grid-cols-1 gap-1">
                                    <div>
                                        {{ $item->product->name }}
                                    </div>
                                    <div>
                                        {!! $item->product->price($item->quantity) !!}
                                    </div>
                                    <div wire:key="{{ md5('auth_cart_item') }}">
                                        @livewire('user-components.cart.manage-auth-cart-item', ['cart_item' => $item], key("auth_cart_item_{$item->id}"))
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="px-3 sm:px-0">
                            <x-paginator :data="$cart_items" />
                        </div>
                        @endauth

                        @guest
                        <div>
                            @livewire('user-components.cart.guest-cart-view', ['cart_items' => $cart_items], key('guest_cart_view'))
                        </div>
                        @endguest
                    </div>
                    @else
                    <div class="flex justify-center items-center">
                        <i style="font-size: 7rem;" class="fas text-blue-700 fa-shopping-cart"></i>
                    </div>
                    <div class="text-center justify-center flex mt-3 text-xl font-bold text-blue-700">
                        <div class="ml-3">
                            <a href="{{ route('home') }}">
                                <x-jet-button class="bg-green-700">
                                    {{ __('shop') }}
                                </x-jet-button>
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </x-slot>

            <x-slot name="footer">
                <div>
                    <x-jet-secondary-button wire:click="$toggle('expanded')" class="mr-4">
                        {{ __('continue shopping') }}
                    </x-jet-secondary-button>

                    <x-jet-button class="bg-blue-800" wire:click="">
                        {{ __('checkout') }}
                    </x-jet-button>
                </div>
            </x-slot>
        </x-jet-dialog-modal>
    </div>
</div>
