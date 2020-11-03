<div>
    <div class="shadow sm:rounded-lg bg-white py-4 px-4">
        <form wire:submit.prevent="edit">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-jet-label for="name" value="{{ __('Specification Name') }}" />
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model="attribute.name" placeholder="specification name" autocomplete="name" />
                    <x-jet-input-error for="attribute.name" class="mt-2" />
                </div>
                <div>
                    <x-jet-label for="value" value="{{ __('Specification Value') }}" />
                    <x-jet-input id="value" type="text" class="mt-1 block w-full" wire:model="attribute.value" placeholder="specification value" autocomplete="value" />
                    <x-jet-input-error for="attribute.value" class="mt-2" />
                </div>
            </div>
            <div>
                <x-jet-label class="mt-1" value="a user can choose which {{ $attribute->singular('name') }} they want?" />
                <ul class="flex">
                    <li class="mr-3">
                        <input id="is_specific" value="{{ true }}" type="radio" wire:model="attribute.is_specific" class="mt-1" /> yes
                    </li>
                    <li>
                        <input id="is_specific" value="{{ false }}" type="radio" wire:model="attribute.is_specific" class="mt-1" /> no
                    </li>
                </ul>
            </div>
            <div class="flex items-center justify-end mt-4 bg-gray-50 text-right">
                <div class="mr-3">
                    <x-jet-secondary-button style="color: white;" class="border border-red-700 bg-red-700" wire:click="delete">
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
