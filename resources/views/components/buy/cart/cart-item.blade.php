@props(['cartItem'])
@php
$product = $cartItem->product;
if($cartItem->specifications) {
$specs = $cartItem->specifications->mapWithKeys(function($spec, $key) {
return [$key . ': ' . $spec];
})->all();
} else {
$specs = false;
}
dump($specs)
@endphp
<div class="flex flex-col p-3 bg-gray-100 sm:flex-row">
    <div class="flex items-start">
        <div style="background-image: url('/storage/{{ $product->gallery->first()->image_url }}'); background-size: cover; background-position: center center;"
            class="w-24 h-24 sm:w-32 sm:h-32 mr-4 md:mr-8">
        </div>

        <div class="grid grid-cols-1">
            <div class="text-xl font-semibold text-gray-800">
                {{ $product->name }}
            </div>

            @if($specs)
            <div class="text-md font-semibold text-gray-800">
                {{-- {{ $specs }} --}}
            </div>
            @endif
        </div>
    </div>
</div>