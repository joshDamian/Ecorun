@props(['product', 'imagebox' => '100%'])
<a href="{{ route('product.show', ['product' => $product->id, 'slug' => $product->data_slug('name')]) }}">
    <div class="bg-white shadow cursor-pointer">
        <div class="flex items-center justify-center">
            <img src="/storage/{{ $product->displayImage() }}" width="{{ $imagebox }}" height="{{ $imagebox }}" class="" />
        </div>
        <div class="text-center font-normal p-2">
            <div class="truncate">
                {{ $product->name }}
            </div>
            <div class="truncate">
                {!! $product->price() !!}
            </div>
        </div>
    </div>
</a>
