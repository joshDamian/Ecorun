<div>
    <x-jet-form-section submit="create">
        <x-slot name="title">
            {{ __('Describe Your Store') }}
        </x-slot>

        <x-slot name="description">
            {{ __('make your store easy to find by describing what you sell.') }}
            <div>
                {{ __('you can edit this later.') }}
            </div>
        </x-slot>

        <x-slot name="form">

            <!-- Description -->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="description" value="{{ __('Description') }}" />
                <textarea rows="5" class="form-input mt-1 block w-full" wire:model="description"
                    autocomplete="description"></textarea>
                <x-jet-input-error for="description" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="setup">
                {{ __('Saved.') }}
            </x-jet-action-message>

            <x-jet-button wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>
</div>
