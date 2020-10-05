<div class="pt-4 sm:pt-0">
    <x-jet-form-section submit="createEnterprise">
        <x-slot name="title">
            {{ __('Enterprise Creation') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Create A New Enterprise.') }}
        </x-slot>

        <x-slot name="form">
            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model="name" autocomplete="name" />
                <x-jet-input-error for="name" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="newEnterprise">
                {{ __('Created.') }}
            </x-jet-action-message>

            <x-jet-button wire:loading.attr="disabled" wire:target="photo">
                {{ __('Create') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>
</div>