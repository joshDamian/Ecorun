@props(['cartItem'])
@php
$product = $cartItem->product;
if($cartItem->specifications) {
$specs = $cartItem->specifications;
} else {
$specs = false;
}
@endphp
<div class="flex flex-col px-3 py-3 bg-gray-100 sm:px-5 sm:flex-row">
    <div class="flex items-start flex-1 sm:mr-4">
        <div style="background-image: url('/storage/{{ $product->gallery->first()->image_url }}'); background-size: cover; background-position: center center;"
            class="flex-shrink-0 w-24 h-24 mr-4 sm:w-28 sm:h-28 md:mr-8">
        </div>

        <div class="grid grid-cols-1">
            <div class="flex items-baseline justify-between ">
                <a class="mr-4 sm:mr-8" href="{{ $product->url->show }}">
                    <div class="text-xl font-extrabold text-blue-700 underline">
                        {{ $product->name }}
                    </div>
                </a>

                <div class="text-xl font-bold text-purple-700">
                    {!! $product->price($cartItem->quantity) !!}
                </div>
            </div>

            <div class="py-1 text-lg font-bold text-purple-700">
                quantity: {{ $cartItem->quantity }}
            </div>

            <div>
                specifications:
            </div>
            <div class="p-2 text-sm font-semibold text-gray-800 border border-gray-300">
                @if($specs)
                @foreach($specs as $key => $spec)
                <span>{{ $key }}: {{ $spec }} @if(!$loop->last), @endif</span>
                @endforeach
                @else
                no specifications.
                @endif
            </div>
        </div>
    </div>

    <div class="flex items-end justify-end mt-3">
        <x-jet-secondary-button wire:click="triggerEdit({{ $cartItem->id ?? $cartItem->product_id }})"
            class="mr-3 text-green-400 border-green-400">
            edit
        </x-jet-secondary-button>

        <x-jet-secondary-button wire:click="triggerDelete({{ $cartItem->id ?? $cartItem->product_id }})"
            class="text-red-400 border-red-400">
            delete
        </x-jet-secondary-button>
    </div>
</div>
