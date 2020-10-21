@props(['products'])
<div class="flex justify-center">
    <div class="grid grid-cols-2 sm:gap-3 md:gap-3 gap-3 sm:grid-cols-3 md:grid-cols-6">
        @foreach($products as $product)
        <a href="{{ route('product.show', ['product' => $product->id, 'name' => $product->name]) }}">
            <div class="bg-white shadow cursor-pointer">
                <div class="flex justify-center">
                    <img src="/storage/{{ $product->displayImage() }}" width="170" height="170" />
                </div>
                <div class="text-center pb-2 pt-2">
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
</div>
@if($products->links()->paginator->hasPages())
<div class="mt-2 text-white">
    {{ $products->links() }}
</div>
@endif
