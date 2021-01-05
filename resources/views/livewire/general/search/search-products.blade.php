<div class="bg-gray-800">
    @forelse ($results as $product)
    <a href="{{ $product->url->show }}">
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
    <div class="px-2 py-2 text-center text-black bg-white">
        no results for {{ $query }}
    </div>
    @endforelse
</div>
