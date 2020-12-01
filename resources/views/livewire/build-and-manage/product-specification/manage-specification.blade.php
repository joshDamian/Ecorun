<div>
    <div class="px-4 py-4 bg-white shadow sm:rounded-lg">
        <form wire:submit.prevent="edit">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <x-jet-label for="name" value="{{ __('Specification Name') }}" />
                    <x-jet-input id="name" type="text" class="block w-full mt-1" wire:model="specification.name" placeholder="specification name" autocomplete="name" />
                    <x-jet-input-error for="specification.name" class="mt-2" />
                </div>
                <div>
                    <x-jet-label for="value" value="{{ __('Specification Value') }}" />
                    <x-jet-input id="value" type="text" class="block w-full mt-1" wire:model="specification.value" placeholder="specification value" autocomplete="value" />
                    <x-jet-input-error for="specification.value" class="mt-2" />
                </div>
            </div>
            <div>
                <x-jet-label class="mt-1" value="a user can choose which {{ $specification->singular('name') }} they want?" />
                <ul class="flex">
                    <li class="mr-3">
                        <input id="is_specific" value="{{ true }}" type="radio" wire:model="specification.is_specific" class="mt-1" /> yes
                    </li>
                    <li>
                        <input id="is_specific" value="{{ false }}" type="radio" wire:model="specification.is_specific" class="mt-1" /> no
                    </li>
                </ul>
            </div>
            <div class="flex items-center justify-end mt-4 text-right bg-gray-50">
                <div class="mr-3">
                    <x-jet-secondary-button style="color: white;" class="bg-red-700 border border-red-700" wire:click="delete">
                        <i class="fa fa-trash"></i>
                    </x-jet-secondary-button>
                </div>
                <x-jet-action-message class="mr-3" on="saved">
                    {{ __('edited.') }}
                </x-jet-action-message>

                <x-jet-button class="bg-green-700" wire:loading.attr="disabled">
                    <i class="fa fa-edit"></i>
                </x-jet-button>
            </div>
        </form>
    </div>
</div>
