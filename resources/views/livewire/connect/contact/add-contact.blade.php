<x-jet-form-section submit="addContact">
    <x-slot name="title">
        <div class="">
            {{ __('Add Phone number') }}
        </div>
    </x-slot>

    <x-slot name="description">
        <div class="text-gray-600">
            @if($contactable::class === User::class)
            {{ __('A valid phone number helps businesses reach out to you, when you make purchases.') }}
            @else
            {{ __('A valid phone number helps customers reach out to your business, for purchases') }}
            @endif
        </div>
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="phone_number" value="{{ __('Phone Number') }}" />
            <div class="flex items-center">
                <select class="block mt-1 mr-4 form-select">
                    <option>+234</option>
                </select>
                <x-jet-input id="phone_number" type="number" class="block w-full mt-1" wire:model="phone_number"
                    autocomplete="phone_number" />
            </div>
            <x-jet-input-error for="phone_number" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="added">
            {{ __('added.') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('Add') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
