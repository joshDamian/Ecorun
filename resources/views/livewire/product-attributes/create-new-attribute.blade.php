<div>
    <div class="grid grid-cols-1 gap-4">
        <div class="px-4">
            <x-jet-button style="width: 49%;" wire:click="add" class="bg-blue-800 border-blue-800 border">
                Add Attribute
            </x-jet-button>
        </div>

        @if($ready)
        <form wire:submit.prevent="create">
            <div class="grid py-4 px-4 bg-white gap-4 grid-cols-1 sm:grid-cols-2">
                <div>
                    <x-jet-label for="name" value="{{ __('Attribute Name (e.g: color)') }}" />
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model="name"
                        placeholder="attribute name" autocomplete="name" />
                    <x-jet-input-error for="name" class="mt-2" />
                </div>
                <div>
                    <x-jet-label for="value" value="{{ __('Attribute Value (e.g: red)') }}" />
                    <x-jet-input id="value" type="text" class="mt-1 block w-full" wire:model="value"
                        placeholder="attribute value" autocomplete="value" />
                    <x-jet-label for="value" value="separate multiple values with a comma(,)" />
                    <x-jet-input-error for="value" class="mt-2" />
                </div>
            </div>
            <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
                <x-jet-action-message class="mr-3" on="added">
                    {{ __('Added.') }}
                </x-jet-action-message>
                <x-jet-button wire:loading.attr="disabled">
                    {{ __('Add') }}
                </x-jet-button>
            </div>
        </form>
        @endif
    </div>
</div>
