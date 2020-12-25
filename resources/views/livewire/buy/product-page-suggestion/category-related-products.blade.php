<div>
    <p class="mb-1 text-blue-700">
        {{ __('related stuff') }}
    </p>
    <x-product.subview-list :count="$this->count()" :products="$products" />
    @if($this->count() > 6)
    <div class="text-right mt-3">
        <a href="{{ route('category.show', ['slug' => $this->product->category->data_slug('title')]) }}">
            <x-jet-button class="bg-blue-700">
                {{ __('see more') }}
            </x-jet-button>
        </a>
    </div>
    @endif
</div>
