@props(['count', 'products'])

@if($count === 0)
<div class="py-2 bg-white">
    <div class="flex justify-center items-center">
        <i style="font-size: 8rem;" class="fa text-blue-700 fa-shopping-bag"></i>
    </div>
    <div class="text-blue-700 text-lg mt-4 font-semibold text-center">
        empty
    </div>
</div>
@else
<div class="flex overflow-x-scroll md:overflow-x-hidden md:grid md:grid-cols-6 md:gap-3">
    @foreach($products as $product)
    <div class="flex-shrink-0 md:mr-0 @if(!$loop->last) mr-2 @endif">
        <x-product.product-preview-card imagebox="185" :product="$product" />
    </div>
    @endforeach
</div>
@endif
