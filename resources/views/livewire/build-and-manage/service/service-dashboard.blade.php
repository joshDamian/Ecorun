<div x-data x-init="() => { window.scrollTo(0, 0); }">
    <div class="grid grid-cols-1 gap-4">
        <div>
            @livewire('build-and-manage.sellable.manage-sellable-images', ['sellable' => $service->sellable],
            key(md5("manage_service_images_for_{$service->id}")))
        </div>
        <div>
            {{--  @livewire('build-and-manage.product.edit-product', ['product' => $product],
            key(md5("edit_product_for_{$product->id}"))) --}}
        </div>

        <div>
            <!-- TODO
                    add component to manage/edit service options
                -->
        </div>

        <div class="grid grid-cols-1 sm:gap-4 sm:grid-cols-6">
            <div class="sm:col-span-2">
            </div>

            <div class="sm:col-span-4">
                <!-- TODO
                    add component to add service options
                -->
            </div>
        </div>
    </div>

    <div class="float-right mt-4 mb-4 text-right">
        <div class="flex">
            <div class="mr-4">
                <!--
                    Generalize deleting and pulbishing sellable
                -->
                {{-- @livewire('build-and-manage.product.delete-product', ['product' => $product],
                key(md5("delete_product_for_{$product->id}"))) --}}
            </div>

            <div>
                {{-- @livewire('build-and-manage.product.publish-product', ['product' => $product],
                key(md5("publish_product_for_{$product->id}"))) --}}
            </div>
        </div>
    </div>
</div>
