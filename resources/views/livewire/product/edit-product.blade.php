<div>
    <x-jet-form-section submit="save">
        <x-slot name="title">
            {{ __('Edit Product Information') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Modify product\'s name, description, price & available quantity') }}
        </x-slot>

        <x-slot name="form">
            <!-- Name -->
            <div class="col-span-12 md:col-span-3 sm:col-span-4">
                <x-jet-label for="name" value="{{ __('Product Name') }}" />
                <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model="product.name"
                    placeholder="product name" autocomplete="name" />
                <x-jet-input-error for="product.name" class="mt-2" />
            </div>

            <!-- Price -->
            <div class="col-span-6 sm:col-span-4 md:col-span-3">
                <x-jet-label for="price" value="{{ __('Product Price') }}" />
                <x-jet-input id="price" type="number" class="mt-1 block w-full" placeholder="product price"
                    wire:model="product.price" autocomplete="price" />
                <x-jet-input-error for="product.price" class="mt-2" />
            </div>

            <!-- Available Stock -->
            <div class="col-span-6 sm:col-span-4 md:col-span-3">
                <x-jet-label for="category">
                    {{__('Available Stock')}}
                    @if ($product->enterprise->isService())
                    <span class="text-green-400">
                        {{__(' (optional) ')}}
                    </span>
                    @endif
                </x-jet-label>
                <x-jet-input id="available_stock" placeholder="available stock" type="number" class="mt-1 block w-full"
                    wire:model="product.available_stock" autocomplete="available_stock" />
                <x-jet-input-error for="product.available_stock" class="mt-2" />
            </div>

            <!-- Description -->
            <div class="col-span-12 md:col-span-3 sm:col-span-4">
                <x-jet-label for="description" value="{{ __('Product Description') }}" />
                <textarea placeholder="product description" rows="3" class="form-input mt-1 block w-full"
                    wire:model="product.description" autocomplete="description"></textarea>
                <x-jet-input-error for="product.description" class="mt-2" />
            </div>

        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Saved.') }}
            </x-jet-action-message>

            <x-jet-button wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>
</div>
