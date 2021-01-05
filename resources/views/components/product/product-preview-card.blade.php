@props(['product', 'imagebox' => '100%'])
<a href="{{ $product->url->show }}">
    <div class="p-3 bg-gray-100">
        <div class="flex items-center justify-center">
            <img src="/storage/{{ $product->displayImage() }}" width="{{ $imagebox }}" height="{{ $imagebox }}"
                class="" />
        </div>
        <div class="pt-3 font-normal text-center text-gray-800">
            <div class="mb-2 truncate">
                {{ $product->name }}
            </div>
            <div class="truncate">
                {!! $product->price() !!}
            </div>
        </div>
    </div>
</a>
