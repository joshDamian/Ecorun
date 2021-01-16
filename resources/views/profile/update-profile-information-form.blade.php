<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="title">
        <div class="">
            {{ __('Email') }}
        </div>
    </x-slot>

    <x-slot name="description">
        <div class="text-gray-600">
            {{ __('Update your account\'s email address.') }}
        </div>
    </x-slot>

    <x-slot name="form">
        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="email" value="{{ __('Email') }}" />
            <x-jet-input id="email" type="email" class="block w-full mt-1" wire:model.defer="state.email" />
            <x-jet-input-error for="email" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="email">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
