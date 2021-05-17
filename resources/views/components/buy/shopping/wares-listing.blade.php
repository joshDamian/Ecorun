@props(['wares'])
<div>
    <div class="grid grid-cols-2 gap-1 sm:gap-1 sm:grid-cols-3 md:grid-cols-4">
        @foreach($wares as $item)
        <div>
            <x-buy.shopping.warehouse-item-preview-card :item="$item" />
        </div>
        @endforeach
    </div>
</div>
