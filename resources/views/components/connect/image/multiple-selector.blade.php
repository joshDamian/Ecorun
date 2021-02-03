@props(['photos'])

<div>
    <div class="grid grid-cols-3 gap-2">
        @foreach ($photos as $key => $photo)
        @php
        $photo_url = $this->validPreviewUrl($photo, $key);
        @endphp
        @if($photo_url)
        <div>
            <div class="text-right">
                <x-jet-secondary-button wire:click="removeFromPhotos({{$key}})" class="p-0 text-red-600">
                    <i class="text-sm fas fa-times"></i>
                </x-jet-secondary-button>
            </div>
            <div class="p-1 border border-gray-300">
                <div id="selected_{{$key}}" wire:ignore
                    style="background-image: url('{{ $photo_url }}'); background-size: cover; background-position: center center;"
                    class="w-full h-20 sm:h-36">
                </div>
            </div>
            <x-jet-input-error for="photos.{{$key}}" />
        </div>
        @endif
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
