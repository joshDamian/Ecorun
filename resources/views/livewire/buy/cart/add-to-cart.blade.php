<div>
    <x-jet-dialog-modal wire:model="add_specs">
        <x-slot name="title">
            <div class="text-left">
                {{ __('Add to cart') }}
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="text-left">
                <p class="mb-2">
                    please specify:
                </p>
                <div class="grid grid-cols-2 gap-3 md:grid-cols-3">
                    <div>
                        <x-jet-label value="quantity" />
                        <x-jet-input wire:model="quantity" type="number" class="block w-full mt-1" />
                        <x-jet-input-error for="quantity" />
                    </div>
                    @if($this->specification_count > 0)
                    @foreach($this->indicated_specs as $spec)
                    <div>
                        <x-jet-label :value="Illuminate\Support\Str::singular($spec->name)" />
                        <div class="relative mt-1">
                            <select name="{{ $spec->singular('name') }}"
                                wire:model="specifications.{{ Illuminate\Support\Str::singular($spec->name) }}"
                                class="block w-full px-4 py-3 pr-8 leading-tight text-white bg-blue-900 border border-blue-900 rounded-lg appearance-none focus:outline-none focus:bg-gray-900 focus:border-gray-900"
                                id="grid-state">
                                <option value="">select an option</option>
                                @foreach($spec->value as $value)
                                <option value="{{ trim($value) }}" @if($value===$spec->value[0])
                                    {{ __('selected') }} @endif> {{ trim($value) }}</option>
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
                        <x-jet-input-error for="specifications.*{{ Illuminate\Support\Str::singular($spec->name) }}" />
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div>
                <x-jet-secondary-button wire:click="$toggle('add_specs')" class="mr-4">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>
                @if($this->specification_count > 0)
                <x-jet-button class="bg-blue-800" wire:click="add_specs_prod">
                    {{ __('add') }}
                </x-jet-button>
                @else
                <x-jet-button class="bg-blue-800" wire:click="add_prod">
                    {{ __('add') }}
                </x-jet-button>
                @endif
            </div>
        </x-slot>
    </x-jet-dialog-modal>
</div>
