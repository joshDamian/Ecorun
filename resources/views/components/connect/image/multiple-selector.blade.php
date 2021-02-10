@props(['photos'])
<div x-data="{
    removeFilePhoto: function(key) {
    var object = this.$refs['file_selected_image_' + key];
    if(object) {
    this.$refs.list.removeChild(object);
    this.$wire.removeFromPhotos(key);
    }
    },
    removeStoredPhoto: function(id) {
    var object = this.$refs['stored_selected_image_' + id];
    if(object) {
    this.$wire.removeFromStoredPhotos(id);
    this.$refs.list.removeChild(object);
    }
    },
    }">
    <div x-ref="list" class="grid grid-cols-3 gap-2">
        @if($this->hasStoredImages)
        @foreach($this->gallery as $key => $image)
        <div x-ref="stored_selected_image_{{$image->id}}">
            <div class="text-right">
                <x-jet-secondary-button x-on:click="removeStoredPhoto({{$image->id}})" class="p-0 text-red-600">
                    <i class="text-sm fas fa-times"></i>
                </x-jet-secondary-button>
            </div>

            <div class="p-1 border border-gray-300">
                <div wire:ignore id="stored_selected_image_{{$image->id}}"
                    style="background-image: url('/storage/{{ $image->image_url }}'); background-size: cover; background-position: center center;"
                    class="w-full h-20 sm:h-36">
                </div>
            </div>
        </div>
        @endforeach
        @endif

        @foreach ($photos as $key => $photo)
        <div x-ref="file_selected_image_{{$key}}">
            <div class="mb-1 font-bold text-right text-gray-600">
                <x-jet-secondary-button x-on:click="removeFilePhoto({{$key}})" class="p-0 text-red-600">
                    <i class="text-sm fas fa-times"></i>
                </x-jet-secondary-button>
            </div>

            <div class="p-1 border border-gray-300">
                <div wire:ignore.self id="file_selected_image_{{$key}}"
                    style="background-image: url('{{ $photo->temporaryUrl() }}'); background-size: cover; background-position: center center;"
                    class="w-full h-20 sm:h-28">
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
