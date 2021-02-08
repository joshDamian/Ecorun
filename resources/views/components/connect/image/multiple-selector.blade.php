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
       var object = this.$refs.list.removeChild(this.$refs['file_selected_image_' + id]);
       if(object) {
            this.$refs.list.removeChild(object);
            this.$wire.removeFromStoredPhotos(id);
       }
    },
    photos: @entangle('photos')
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
                <div id="stored_selected_image_{{$image->id}}" wire:ignore.self
                    style="background-image: url('/storage/{{ $image->image_url }}'); background-size: cover; background-position: center center;"
                    class="w-full h-20 sm:h-36">
                </div>
            </div>
        </div>
        @endforeach
        @endif

        <template x-for="(photo, index) in photos">
            <div x-ref="'file_selected_image_' + index">
                <div class="flex items-center justify-between mb-1 font-bold text-center text-gray-600">
                    <div x-text="index + 1" class="flex-1 text-center">
                    </div>

                    <div class="text-right">
                        <x-jet-secondary-button x-on:click="removeFilePhoto(index)" class="p-0 text-red-600">
                            <i class="text-sm fas fa-times"></i>
                        </x-jet-secondary-button>
                    </div>
                </div>

                <div class="p-1 border border-gray-300">
                    <div wire:ignore.self
                        :style="'background-image: url('+ photo +'); background-size: cover; background-position: center center;'"
                        class="w-full h-20 sm:h-36">
                    </div>
                </div>
                {{-- <x-jet-input-error for="'photos.' + index" /> --}}
            </div>
        </template>

        {{-- @foreach ($photos as $key => $photo)
        <div x-ref="file_selected_image_{{$key}}">
        <div class="flex items-center justify-between mb-1 font-bold text-center text-gray-600">
            <div class="flex-1 text-center">
                {{ $key + 1 }}
            </div>

            <div class="text-right">
                <x-jet-secondary-button x-on:click="removeFilePhoto({{$key}})" class="p-0 text-red-600">
                    <i class="text-sm fas fa-times"></i>
                </x-jet-secondary-button>
            </div>
        </div>

        <div class="p-1 border border-gray-300">
            <div wire:ignore.self wire:key="file_selected_image_{{$key}}"
                style="background-image: url('{{ $photo->temporaryUrl() }}'); background-size: cover; background-position: center center;"
                class="w-full h-20 sm:h-36">
            </div>
        </div>
        <x-jet-input-error for="photos.{{$key}}" />
    </div>
    @endforeach --}}
    <div class="flex items-end">
        <x-jet-secondary-button x-on:click="$refs.addedPhotos.click()" class="text-blue-700">
            <i class="fas fa-plus"></i>
        </x-jet-secondary-button>
    </div>
</div>
<input name="addedImages" class="hidden" x-ref="addedPhotos" accept="image/*" type="file" wire:model="addedImages"
    multiple />
</div>
