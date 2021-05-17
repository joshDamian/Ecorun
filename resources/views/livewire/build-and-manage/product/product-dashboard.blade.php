<div x-data x-init="() => { window.scrollTo(0, 0); }">
    <div class="grid grid-cols-1 gap-4">
        <div>
            @livewire('build-and-manage.warehouse.manage-item-images', ['item' => $item],
            key(md5("manage_item_images_for_{$item->id}")))
        </div>
        <div>
            @livewire('build-and-manage.product.edit-product', ['product' => $product],
            key(md5("edit_product_for_{$product->id}")))
        </div>

        <div>
            @livewire('build-and-manage.product.manage-product-specifications', ['product' => $product],
            key(md5("manage_product_specifications_for_{$product->id}")))
        </div>

        <div class="grid grid-cols-1 sm:gap-4 sm:grid-cols-6">
            <div class="sm:col-span-2">
                <x-jet-section-title>
                    <x-slot name="title">
                        Add Specification
                    </x-slot>

                    <x-slot name="description">
                        Add a new specification to product
                    </x-slot>
                </x-jet-section-title>
            </div>
            <div class="sm:col-span-4">
                @livewire('build-and-manage.product-specification.create-new-specification', ['product' => $product],
                key(md5("create_new_specification_for_{$product->id}")))
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 pt-2 sm:gap-4 sm:grid-cols-6">
        <div class="pt-4 sm:col-span-2">
            <x-jet-section-title>
                <x-slot name="title">
                    Warehouse Management
                </x-slot>

                <x-slot name="description">
                    Remove, Publish item from/in warehouse
                </x-slot>
            </x-jet-section-title>
        </div>

        <div class="flex justify-end p-4 mt-4 bg-gray-100 sm:rounded-md sm:shadow-md sm:col-span-4">
            <div class="mr-4">
                @livewire('build-and-manage.warehouse.delete-item', ['item' => $item],
                key(md5("delete_item_for_{$item->id}")))
            </div>
            <div>
                @livewire('build-and-manage.warehouse.publish-item', ['item' => $item],
                key(md5("publish_item_for_{$item->id}")))
            </div>
        </div>
    </div>
</div>
