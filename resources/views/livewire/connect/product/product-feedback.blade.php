<div x-data="{ shared: false, timeout: null, event: 'newShare.{{ $feedback_id . '.' . str_replace('\\', '.', get_class($product)) }}' }"
    x-init="
    Livewire.on(event, () => { clearTimeout(timeout); shared = true; timeout = setTimeout(() => { shared = false }, 2000);  })">
    <div class="flex justify-between px-3 py-4 bg-gray-100 border-t border-gray-200 sm:px-5 sm:py-3">
        <div class="flex-grow mr-3">
            @livewire('buy.cart.cart-trigger', ['product' => $product, 'view' => 'feed'], key('trigger_cart_item' .
            $product->id .
            microtime()))
        </div>

        <a class="flex items-center justify-center flex-grow px-3 py-2 mr-3 font-bold text-center text-blue-700 bg-white rounded-full"
            href="{{ $product->url->show }}">
            <i class="text-xl text-blue-700 fas fa-shopping-bag"></i> <span class="hidden sm:inline">&nbsp; Shop</span>
        </a>

        @auth
        <div x-data="{ liked: '{{ $this->liked() }}', clicked: null }"
            class="flex-grow px-3 py-2 mr-3 bg-white rounded-full">
            <div class="flex items-center justify-center">
                <div class="flex items-baseline justify-center justify-items-center">
                    <i @click=" liked = (liked === '1') ? null : '1';"
                        :class="(liked === '1') ? 'text-red-700 fas' : 'text-blue-700 far'" wire:click="like"
                        class="text-xl fa-heart md:cursor-pointer"></i>
                </div>
                @php
                $likes_count = $this->likes();
                @endphp
                @if($likes_count > 0)
                <div class="ml-2 font-bold text-gray-700 text-md">
                    {{ $likes_count }}
                </div>
                @endif
            </div>
        </div>

        <div class="flex items-center justify-center flex-grow px-3 py-2 bg-white rounded-full">
            <i wire:click="share" class="text-xl text-blue-700 cursor-pointer fas fa-share-alt"></i>
            @php
            $shares_count = $this->shares();
            @endphp
            @if($shares_count > 0)
            <div class="ml-2 font-bold text-gray-700 text-md">
                {{ $shares_count }}
            </div>
            @endif
        </div>
        @endauth
    </div>

    @auth
    <div x-show.transition.opacity.out.duration.1500ms="shared"
        class="px-3 py-1 font-bold text-center text-white bg-blue-800 text-md">
        you shared this product on your timeline &nbsp; <i class="text-white fas fa-check"></i>
    </div>
    @endauth
</div>
