<div>
    <x-jet-form-section submit="edit">
        <x-slot name="title">
            {{ __('Store Description') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Edit your store\'s description.') }}
        </x-slot>

        <x-slot name="form">
            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="description" value="{{ __('Description') }}" />
                <textarea rows="5" class="form-input mt-1 block w-full" wire:model="store.description"
                    autocomplete="description"></textarea>
                <x-jet-input-error for="store.description" class="mt-2" />
            </div>

        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Saved.') }}
            </x-jet-action-message>

            <x-jet-button>
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>
</div>
