<div class="grid grid-cols-1 gap-2">
    <x-jet-button class="bg-green-500">
        Eco-transact
    </x-jet-button>
    @if(false)
    <div>
        <x-jet-label value="quantity" />
        <x-jet-input wire:model="order.quantity" type="number" class="block w-full mt-1" />
        <x-jet-input-error for="order.quantity" />
    </div>
    @foreach($raw_specs as $key => $spec)
    <div>
        <x-jet-label :value="$spec->singular('name')" />
        <div class="relative mt-1">
            <select name="{{ $spec->singular('name') }}" wire:model="selected_specs.{{ $spec->singular('name') }}"
                class="block w-full px-4 py-3 pr-8 leading-tight text-white bg-blue-900 border border-blue-900 rounded appearance-none form-select focus:outline-none focus:bg-gray-900 focus:border-gray-900"
                id="grid-state">
                @foreach($spec->value as $value)
                <option value="{{ trim($value) }}">{{ trim($value) }}</option>
                @endforeach
            </select>
        </div>
        <x-jet-input-error for="selected_specs.*{{ $spec->singular('name') }}" />
    </div>
    @endforeach
    @endif
</div>
