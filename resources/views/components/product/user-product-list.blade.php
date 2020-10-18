@props(['products'])
<div class="grid grid-cols-2 sm:gap-4 gap-2 sm:grid-cols-3 md:grid-cols-6">
    @foreach($products as $product)
    <a href="{{ route('product.show', ['product' => $product->id, 'name' => $product->name]) }}">
        <div class="bg-white shadow cursor-pointer">
            <div class="flex justify-center">
                <img src="/storage/{{ $product->displayImage() }}" width="200" height="200" />
            </div>
            <div class="text-center py-2 px-2">
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
@if($products->links()->paginator->hasPages())
<div class="mt-2">
    {{ $products->links() }}
</div>
@endif
