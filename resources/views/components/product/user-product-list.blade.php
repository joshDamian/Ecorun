@props(['products'])
<div>
    @if($products->count() < 3)
    <div class="flex flex-wrap md:bg-white md:py-3 items-center justify-center">
        @foreach($products as $product)
        <a href="{{ route('product.show', ['product' => $product->id, 'name' => $product->name]) }}">
            <div class="bg-white @if(!$loop->last) mr-1 @endif shadow py-4 px-4 cursor-pointer">
                <div class="flex items-center justify-center">
                    <img src="/storage/{{ $product->displayImage() }}" width="110" height="110" />
                </div>
                <div class="text-center pt-2">
                    <div class="truncate">
                        {{ $product->name }}
                    </div>
                    <div class="truncate">
                        {!! $product->price() !!}
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    @elseif($products->count() >= 3)
    <div class="grid grid-cols-2 gap-1 sm:grid-cols-3 md:grid-cols-6">
        @foreach($products as $product)
        <a href="{{ route('product.show', ['product' => $product->id, 'name' => $product->name]) }}">
            <div class="bg-white shadow py-4 px-4 cursor-pointer">
                <div class="flex items-center justify-center">
                    <img src="/storage/{{ $product->displayImage() }}" width="110" height="110" />
                </div>
                <div class="text-center pt-2">
                    <div class="truncate">
                        {{ $product->name }}
                    </div>
                    <div class="truncate">
                        {!! $product->price() !!}
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @endif 
</div>
