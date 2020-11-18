<div class="bg-white pt-3 md:rounded-lg shadow">
    <form wire:submit.prevent="update">
        <div class="px-4 md:px-6">
            <x-jet-label for="description" value="{{ __('Description') }}" />
            <textarea id="description" rows="5" class="form-input mt-1 block w-full" placeholder="enter description" wire:model="profile.description" autocomplete="description"></textarea>
            <x-jet-input-error for="profile.description" class="mt-2" />
        </div>

        <div class="flex items-center justify-end md:rounded-b-lg  px-4 py-3 bg-gray-50 text-right sm:px-6">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Saved.') }}
            </x-jet-action-message>

            <x-jet-button wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </div>
    </form>
</div>
