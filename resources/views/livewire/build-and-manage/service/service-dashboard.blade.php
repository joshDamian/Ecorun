<div x-data x-init="() => { window.scrollTo(0, 0); }">
    <div class="grid grid-cols-1 gap-4">
        <div>
            @livewire('build-and-manage.warehouse.manage-item-images', ['item' => $item],
            key(md5("manage_service_images_for_{$service->id}")))
        </div>
        <div>
            @livewire('build-and-manage.service.edit-service', ['service' => $service],
            key(md5("edit_service_for_{$service->id}")))
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
    <div class="grid grid-cols-1 sm:gap-4 sm:grid-cols-6">
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
                key(md5("delete_service_for_{$item->id}")))
            </div>
            <div>
                @livewire('build-and-manage.warehouse.publish-item', ['item' => $item],
                key(md5("publish_sellable_for_{$item->id}")))
            </div>
        </div>
    </div>
</div>
