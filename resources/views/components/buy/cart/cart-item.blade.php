@props(['cartItem'])
@php
$product = $cartItem->product;
if($cartItem->specifications) {
$specs = $cartItem->specifications;
} else {
$specs = false;
}
@endphp
<div class="flex flex-col p-2 bg-gray-100 sm:flex-row">
    <div class="flex sm:mr-4 items-start">
        <div style="background-image: url('/storage/{{ $product->gallery->first()->image_url }}'); background-size: cover; background-position: center center;"
            class="w-24 h-24 sm:w-32 flex-shrink-0 sm:h-32 mr-4 md:mr-8">
        </div>

        <div class="grid grid-cols-1">
            <div class="text-xl font-semibold text-gray-800">
                {{ $product->name }}
            </div>

            <div>
                options:
            </div>
            <div class="text-sm border p-2 border-gray-200 font-semibold text-gray-800">
                @if($specs)
                @foreach($specs as $key => $spec)
                <span>{{ $key }}:  {{ $spec }} @if(!$loop->last), @endif</span>
                @endforeach
                @else
                no options
                @endif
            </div>
        </div>
    </div>

    <div class="flex items-end justify-end mt-3">
        <x-jet-secondary-button class="border-green-400 mr-3 text-green-400">
            edit
        </x-jet-secondary-button>

        <x-jet-secondary-button class="border-red-400 text-red-400">
            delete
        </x-jet-secondary-button>
    </div>
</div>