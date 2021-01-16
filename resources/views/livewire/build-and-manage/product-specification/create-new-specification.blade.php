<div>
    <div>
        <div class="@if($ready) mb-3 @endif pl-4 sm:pl-0">
            <x-jet-button wire:click="add" class="bg-blue-800 border border-blue-800">
                Add Specification
            </x-jet-button>
        </div>

        @if($ready)
        <div>
            <form wire:submit.prevent="create">
                <div x-data x-init="() => { $refs.name.scrollIntoView(); $refs.name_input.focus(); }" class="grid grid-cols-1 gap-4 px-4 pt-4 pb-2 bg-white sm:grid-cols-2">
                    <div x-ref="name">
                        <x-jet-label for="name" value="{{ __('Specification Name (e.g: color)') }}" />
                        <x-jet-input x-ref="name_input" id="name" type="text" class="block w-full mt-1" wire:model="name" placeholder="specification name" autocomplete="name" />
                        <x-jet-label for="value" value="specification names should be unique" />
                        <x-jet-input-error for="name" class="mt-2" />
                    </div>
                    <div>
                        <x-jet-label for="value" value="{{ __('Specification Value (e.g: red)') }}" />
                        <x-jet-input id="value" type="text" class="block w-full mt-1" wire:model="value" placeholder="specification value" autocomplete="value" />
                        <x-jet-label for="value" value="separate multiple values with a comma(,)" />
                        <x-jet-input-error for="value" class="mt-2" />
                    </div>
                </div>
                <div class="px-4 bg-white">
                    @if($name && !$errors->has('name'))
                    <x-jet-label value="can a user choose which {{ Illuminate\Support\Str::singular($name) }} they want?" />
                    <ul class="flex">
                        <li class="mr-3"><input type="radio" name="is_specific" value="{{ true }}" wire:model.defer="is_specific" /> yes</li>
                        <li><input type="radio" name="is_specific" value="{{ false }}" wire:model.defer="is_specific" /> no</li>
                    </ul>
                    @endif
                </div>
                <div class="flex items-center justify-end px-4 py-3 text-right bg-gray-50 sm:px-6">
                    <x-jet-action-message class="mr-3" on="added">
                        {{ __('Added.') }}
                    </x-jet-action-message>

                    <x-jet-secondary-button wire:click="nevermind" wire:loading.attr="disabled" class="mr-3">
                        {{ __('Nevermind') }}
                    </x-jet-secondary-button>

                    <x-jet-button wire:loading.attr="disabled">
                        {{ __('Add') }}
                    </x-jet-button>
                </div>
            </form>
        </div>
        @endif
    </div>
</div>
