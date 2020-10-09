<div>
    <div class="grid grid-cols-1 gap-4">
        <div>
            @livewire('product.manage-images', ['product' => $product])
        </div>
        <div>
            @livewire('product.edit-product', ['product' => $product])
        </div>

        <div>
            @livewire('product-attributes.manage-attributes', ['product' => $product])
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-6">
            <div class="sm:col-span-2">

            </div>
            <div class="sm:col-span-4">
                @livewire('product-attributes.create-new-attribute', ['product' => $product])
            </div>
        </div>
    </div>
</div>
