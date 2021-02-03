@props(['photos'])

<div>
    <div class="grid grid-cols-3 gap-2">
        @foreach ($photos as $key => $photo)
        @php $wire_key = 'selected_' . mt_rand(1, 4000000); @endphp

        <div wire:key="{{$wire_key}}" id="{{$wire_key}}">
            <div class="text-right">
                <x-jet-secondary-button wire:click="removeFromPhotos({{$key}})" class="p-0 text-red-600">
                    <i class="text-sm fas fa-times"></i>
                </x-jet-secondary-button>
            </div>
            <div class="p-1 border border-gray-300">
                <div wire:ignore.self
                    style="background-image: url('{{ $photo->temporaryUrl() }}'); background-size: cover; background-position: center center;"
                    class="w-full h-20 sm:h-36">
                </div>
            </div>
            <x-jet-input-error for="photos.{{$key}}" />
        </div>
        @endforeach
        <div class="flex items-end">
            <x-jet-secondary-button x-on:click="$refs.addedPhotos.click()" class="text-blue-700">
                <i class="fas fa-plus"></i>
            </x-jet-secondary-button>
        </div>
    </div>
    <input name="addedImages" class="hidden" x-ref="addedPhotos" accept="image/*" type="file" wire:model="addedImages"
    multiple />
</div>