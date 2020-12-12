<div class="bg-gray-800">
    @forelse ($results as $product)
    <a href="{{ route('product.show', ['slug' => $product->data_slug('name'), 'product' => $product->id]) }}">
        <div class="py-2 px-2 grid gap-4 grid-cols-3 @if(!$loop->last) border-b-2 border-gray-900 @endif">
            <img src="/storage/{{ $product->displayImage() }}" class="col-span-1" height="60" width="60">
            <div class="col-span-2">
                <div class="truncate">
                    {{ $product->name }}
                </div>
                <div class="truncate">
                    {!! $product->price() !!}
                </div>
            </div>
        </div>
    </a>
    @empty
    <div class="py-2 bg-white text-black px-2 text-center">
        no results for {{ $query }}
    </div>
    @endforelse
</div>