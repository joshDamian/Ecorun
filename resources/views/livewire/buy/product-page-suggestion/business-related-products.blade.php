<div>
    <p class="mb-1 text-blue-700">
        {{ __('stuff from ') . ucwords($this->product->enterprise->name)  }}
    </p>
    <x-product.subview-list :count="$this->count()" :products="$products" />
    @if($this->count() > 6)
    <div class="text-right mt-3">
        <a href="#">
            <x-jet-button class="bg-blue-700">
                {{ __('visit ' . $this->product->enterprise->name) }}
            </x-jet-button>
        </a>
    </div>
    @endif
</div>
