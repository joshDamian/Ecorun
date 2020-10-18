<div>
    @if($attributes->count() > 0)
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-6">
        <div class="sm:col-span-2">
            <x-jet-section-title>
                <x-slot name="title">
                    {{ __('Product Atrributes') }}
                </x-slot>
                <x-slot name="description">
                    {{ __('And new and modify existing product attributes') }}
                </x-slot>
            </x-jet-section-title>
        </div>
        <div class="sm:col-span-4">
            <div
                class="grid sm:gap-4 gap-2 @if($attributes->count() < 2) gid-cols-1 @else grid-cols-2 @endif sm:grid-cols-2">
                @foreach ($attributes as $attribute)
                @livewire('product-attributes.manage-attribute', ['attribute' => $attribute], key($attribute->id))
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
