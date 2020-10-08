<div>
    <x-jet-form-section submit="create">
        <x-slot name="title">
            {{ __('Add Product') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Add a new product to your sales collection') }}
        </x-slot>

        <x-slot name="form">
            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="name" value="{{ __('Product Name') }}" />
                <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model="name"
                    placeholder="product name" autocomplete="name" />
                <x-jet-input-error for="name" class="mt-2" />
            </div>

            <!-- Price -->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="price" value="{{ __('Product Price') }}" />
                <x-jet-input id="price" type="number" class="mt-1 block w-full" placeholder="product price"
                    wire:model="price" autocomplete="price" />
                <x-jet-input-error for="price" class="mt-2" />
            </div>

            <!-- Available Stock -->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="available_stock" value="{{ __('Available Stock') }}" />
                <x-jet-input id="available_stock" placeholder="available stock" type="number" class="mt-1 block w-full"
                    wire:model="available_stock" autocomplete="available_stock" />
                <x-jet-input-error for="available_stock" class="mt-2" />
            </div>

            <!-- Description -->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="description" value="{{ __('Product Description') }}" />
                <textarea placeholder="product description" rows="5" class="form-input mt-1 block w-full"
                    wire:model="description" autocomplete="description"></textarea>
                <x-jet-input-error for="description" class="mt-2" />
            </div>

        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="added">
                {{ __('Added.') }}
            </x-jet-action-message>

            <x-jet-button wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>
</div>
