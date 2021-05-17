@props(['item', 'imagebox' => '100%', 'sellable' => $item->sellable])
<a href="{{ $sellable->url->show }}">
    <div class="p-3 bg-gray-100">
        <div class="flex items-center justify-center">
            <img src="/storage/{{ $sellable->gallery->first()->image_url }}" width="{{ $imagebox }}"
                height="{{ $imagebox }}" class="" />
        </div>
        <div class="pt-3 font-normal text-center text-gray-800">
            <div class="mb-2 truncate">
                {{ $sellable->name }}
            </div>
            <div class="truncate">
                @if($sellable->price)
                {!! $sellable->price() !!}
                @else
                {{ __('quotation') }}
                @endif
            </div>
        </div>
    </div>
</a>
