@props(['product'])
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
    <div>
        @livewire('product-attributes.create-new-attribute', ['product' => $product])
    </div>
</div>