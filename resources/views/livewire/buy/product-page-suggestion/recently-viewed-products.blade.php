<div>
    <p class="mb-1 text-blue-700">
        {{ __('recently viewed ') }}
    </p>
    <x-product.subview-list :products="$products" :count="$this->count()" />
    @if($this->count() > 6)
    <div class="text-right mt-3">
        <a href="{{ route('view-history.index') }}">
            <x-jet-button class="bg-blue-700">
                {{ __('View History') }}
            </x-jet-button>
        </a>
    </div>
    @endif
</div>
