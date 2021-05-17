<div class="pt-3 bg-white shadow md:rounded-lg">
    <form wire:submit.prevent="update">
        <div class="grid grid-cols-9">
            <div class="grid grid-cols-1 col-span-9 gap-6 px-4 sm:col-span-7 md:gap-4 md:px-6">
                <!-- Phone number -->
                <x-jet-label for="phone_number" value="{{ __('Phone Number') }}" />
                <div class="flex items-center">
                    <select class="block mt-1 mr-4 form-select">
                        <option>+234</option>
                    </select>
                    <x-jet-input id="phone_number" type="number" class="block w-full mt-1" wire:model="contact.phone"
                        autocomplete="phone_number" />
                </div>
                <x-jet-input-error for="contact.phone" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end px-4 py-3 mt-4 text-right md:rounded-b-lg bg-gray-50 sm:px-6">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Saved.') }}
            </x-jet-action-message>

            <x-jet-button wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </div>
    </form>
</div>
