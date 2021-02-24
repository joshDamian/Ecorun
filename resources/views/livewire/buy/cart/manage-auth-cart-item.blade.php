<div>
    <x-jet-dialog-modal wire:model="confirm">
        <x-slot name="title">
            <div class="text-left">
                {{ __('Edit Cart Item') }}
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="text-left">
                <x-jet-action-message on="saved">
                    <div
                        class="px-3 py-2 mb-2 text-lg font-bold text-center text-green-600 bg-gray-100 border border-green-600 rounded-md">
                        saved
                    </div>
                </x-jet-action-message>

                <div class="grid grid-cols-2 gap-3 md:grid-cols-3">
                    <div>
                        <x-jet-label value="quantity" />
                        <x-jet-input wire:model="cartItem.quantity" type="number" class="block w-full mt-1" />
                        <x-jet-input-error for="cartItem.quantity" />
                    </div>

                    @if($this->selectableSpecs->count() > 0)
                    @foreach($this->selectableSpecs as $spec)
                    <div>
                        <x-jet-label :value="$spec->singular('name')" />
                        <div class="relative mt-1">
                            <select name="{{ $spec->singular('name') }}"
                                wire:model="specifications.{{ $spec->singular('name') }}"
                                class="block w-full px-4 py-3 pr-8 leading-tight text-white bg-blue-900 border border-blue-900 rounded-lg appearance-none focus:outline-none focus:bg-gray-900 focus:border-gray-900"
                                id="grid-state">
                                <option value="">select an option</option>
                                @foreach($spec->value as $value)
                                <option value="{{ trim($value) }}"> {{ trim($value) }}</option>
                                @endforeach
                            </select>
                            <div
                                class="absolute inset-y-0 right-0 flex items-center px-2 text-white pointer-events-none">
                                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                        <x-jet-input-error for="specifications.*{{ $spec->singular('name') }}" />
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div>
                <x-jet-secondary-button wire:click="cancel" class="mr-4 text-red-500 border-red-500">
                    {{ __('close') }}
                </x-jet-secondary-button>

                <x-jet-secondary-button class="text-blue-700 border-blue-700" wire:click="edit">
                    {{ __('save') }}
                </x-jet-secondary-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>
</div>
