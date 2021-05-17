<div>
    <x-jet-form-section submit="save">
        <x-slot name="title">
            {{ __('Edit Service Information') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Modify Service\'s name, description, and price') }}
        </x-slot>

        <x-slot name="form">
            <!-- Name -->
            <div class="col-span-12 md:col-span-6 sm:col-span-4">
                <x-jet-label for="name" value="{{ __('Service Name') }}" />
                <x-jet-input id="name" type="text" class="block w-full mt-1" wire:model="service.name"
                    placeholder="Service name" autocomplete="name" />
                <x-jet-input-error for="service.name" class="mt-2" />
            </div>

            <!-- Price -->
            <div class="col-span-6 sm:col-span-4 md:col-span-3">

                <x-jet-label value="Pricing" />
                <select class="form-select" disabled>
                    <option value="{{ $service->pricing }}">
                        {{ $pricing_map[$service->pricing] }}
                    </option>
                </select>
                @if($service->pricing === 'fixed')
                <div class="mt-4 sm:mt-6">
                    <x-jet-label for="price" value="{{ __('Service Price') }}" />
                    <x-jet-input id="price" type="number" class="block w-full mt-1" placeholder="service price"
                        wire:model="service.price" autocomplete="price" />
                    <x-jet-input-error for="service.price" class="mt-2" />
                </div>
                @endif
            </div>

            <!-- Description -->
            <div class="col-span-12 md:col-span-6 sm:col-span-4">
                <x-jet-label for="description" value="{{ __('Service Description') }}" />
                <textarea placeholder="Service description" rows="3" class="block w-full mt-1 form-input"
                    wire:model="service.description" autocomplete="description"></textarea>
                <x-jet-input-error for="service.description" class="mt-2" />
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
