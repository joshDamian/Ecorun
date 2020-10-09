<div>
    <div x-data="{add_photos: null, photos: []}">
        <div class="text-right mb-4">
            <x-jet-button x-on:click=" ; add_photos = true" class="bg-blue-900">
                {{ __('add photos') }}
            </x-jet-button>
        </div>
        <div>
            <div class="mt-2" x-show.transition="photos.length > 0">
                <div class="grid grid-cols-2 sm:grid-cols-3 sm:gap-4 gap-2">
                    <template x-for="photo in photos">
                        <div
                            x-bind:style="'width: 100%; height: 150px; background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photo.url + '\');'">
                        </div>
                    </template>
                </div>

                <div class="mt-2" x-show.transition="isUploading">
                    <progress max="100" x-bind:value="progress"></progress>
                </div>
            </div>
        </div>

        <x-jet-input-error for="photos.*" class="mt-2" />

    </div>
    <div x-show.transtion="! add_photos" class="grid grid-cols-2 sm:grid-cols-3 sm:gap-4 gap-2">
        @foreach($product->gallery as $image)
        <div class="">
            <img class="w-100 h-100" src="/storage/{{$image->image_url}}" />
            <div class="bg-black py-2 text-right px-2">
                <x-jet-button wire:click="deleteImage('{{ $image->id }}')">
                    <i class="fa fa-trash"></i>
                </x-jet-button>
            </div>
        </div>
        @endforeach
    </div>
</div>
</div>