<div x-data x-init="() => { window.scrollTo(0, 0); }">
    <div class="grid grid-cols-1 gap-4">
        <div>
            @livewire('build-and-manage.product.manage-product-images', ['product' => $product])
        </div>
        <div>
            @livewire('build-and-manage.product.edit-product', ['product' => $product])
        </div>

        <div>
            @livewire('build-and-manage.product.manage-product-specifications', ['product' => $product])
        </div>

        <div class="grid grid-cols-1 sm:gap-4 sm:grid-cols-6">
            <div class="sm:col-span-2">
            </div>

            <div class="sm:col-span-4">
                @livewire('build-and-manage.product-specification.create-new-specification', ['product' => $product])
            </div>
        </div>
    </div>
    <div class="float-right mt-4 mb-4 text-right">
        <div class="flex">
            <div class="mr-4">
                @livewire('build-and-manage.product.delete-product', ['product' => $product])
            </div>
            
            <div>
                @livewire('build-and-manage.product.publish-product', ['product' => $product])
            </div>
        </div>
    </div>
</div>
