@props(['cartItem'])
@php
$product =$cartItem->product;
if($cartItem->specifications) {
$specs = implode(", ", $cartItem->specifications->map(function($spec) {
return $spec->name . ': ' . $spec->value;
})->toArray());
} else {
$specs = false;
}
@endphp
<div class="flex flex-col p-3 bg-gray-100 md:flex-row">
    <div class="flex md:items-center">
        <div style="background-image: url('/storage/{{ $product->gallery->first()->image_url }}'); background-size: cover; background-position: center center;"
            class="w-32 h-32 mr-4 md:mr-8">
        </div>

        <div class="grid grid-cols-1">
            <div class="text-xl font-semibold text-gray-800">
                {{ $product->name }}
            </div>

            @if($specs)
            <div class="text-xl font-semibold text-gray-800">
                {{ $specs }}
            </div>
            @endif
        </div>
    </div>
</div>
