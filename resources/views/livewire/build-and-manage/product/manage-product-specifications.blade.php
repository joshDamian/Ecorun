<div>
    @if($specifications_count > 0)
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-6">
        <div class="sm:col-span-2">
            <x-jet-section-title>
                <x-slot name="title">
                    {{ __('Product Specifications') }}
                </x-slot>
                <x-slot name="description">
                    {{ __('And new and modify existing product specifications') }}
                </x-slot>
            </x-jet-section-title>
        </div>
        <div class="sm:col-span-4">
            <div class="grid sm:gap-4 gap-2 @if($specifications_count < 2) grid-cols-1 @else grid-cols-2 @endif sm:grid-cols-2">
                @foreach ($specifications as $specification)
                @livewire('build-and-manage.product-specification.manage-specification', ['specification' => $specification], key($specification->id))
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
