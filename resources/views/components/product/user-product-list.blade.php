@props(['products', 'minimum' => ($products->count() < 3), 'maximum'=> ($products->count() >= 3)])
    <div>
        @if($minimum)
        <div class="flex md:py-2 px-2 md:px-0 items-center justify-center">
            @foreach($products as $product)
            <div class="@if(!$loop->last) mr-2 @endif">
                <x-product.product-preview-card :product="$product" imagebox="180" />
            </div>
            @endforeach
        </div>

        @elseif($maximum)
        <div class="grid grid-cols-2 gap-2 sm:gap-2 sm:grid-cols-3 md:grid-cols-5">
            @foreach($products as $product)
            <div>
                <x-product.product-preview-card :product="$product" />
            </div>
            @endforeach
        </div>
        @endif
    </div>