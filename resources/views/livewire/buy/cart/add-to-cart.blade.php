<div>
    <div>
        @if($this->existing())
        <div>
            @livewire('user-components.cart.cart-trigger', ['view' => 'button'], key(md5('cart_trigger_3')))
        </div>
        @else
        <button wire:click="request_data" class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
            Add to cart &nbsp;<i class="fas fa-plus-circle"></i>
        </button>
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
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        <div>
                            <x-jet-label value="quantity" />
                            <x-jet-input wire:model="quantity" type="number" class="w-full block mt-1" />
                            <x-jet-input-error for="quantity" />
                        </div>
                        @if($this->product->indicatedSpecs()->count() > 0)
                        @foreach($this->product->indicatedSpecs() as $spec)
                        <div>
                            <x-jet-label :value="Illuminate\Support\Str::singular($spec->name)" />
                            <div class="relative mt-1">
                                <select name="{{ $spec->singular('name') }}" wire:model="specifications.{{ Illuminate\Support\Str::singular($spec->name) }}" class="block appearance-none w-full bg-blue-900 border border-blue-900 text-white py-3 px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-gray-900 focus:border-gray-900" id="grid-state">
                                    <option value="">select an option</option>
                                    @foreach($spec->value as $value)
                                    <option value="{{ trim($value) }}" @if($value===$spec->value[0]) {{ __('selected') }} @endif> {{ trim($value) }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-white">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
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
                    @if($this->product->indicatedSpecs()->count() > 0)
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
        @endif
    </div>
</div>
