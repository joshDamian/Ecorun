<div>
    @livewire('product.modify-product-data', ['product' => $product])
    <div class="mt-4 text-right">
        <x-jet-button wire:click="publish">
            {{ __('Publish') }}
        </x-jet-button>
    </div>
</div>
