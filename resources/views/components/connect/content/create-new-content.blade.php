@props(['photos', 'type'])
<div>
    <form wire:submit.prevent="create">
        <div x-data>
            <div>
                <div class="flex justify-center text-blue-600" style="width: 100%;" wire:loading>
                    <div class="text-xl text-center">
                        loading &nbsp; <i class="fas fa-spin fa-spinner"></i>
                    </div>
                    {{-- <x-loader /> --}}
                </div>

                <div class="flex items-baseline justify-between mb-2">
                    <x-jet-label class="mr-5 text-lg font-semibold" value="{{ $type }}" />
                    @error('content' ?? 'photos')
                    <div class="text-red-700">
                        please add something!
                    </div>
                    @enderror
                </div>
                <textarea autofocus  rows="3" wire:model.defer="content" placeholder="say something" class="w-full rounded-md form-textarea"></textarea>

                <div class="mt-3">
                    <input class="hidden" x-ref="photos" accept="image/*" type="file" wire:model="photos" multiple>
                    <span @click=" $refs.photos.click() " class="font-semibold text-blue-800 cursor-pointer">
                        <i class="fas fa-images"></i> &nbsp;Photos (Max 5MB)
                    </span>
                    @if($photos)
                    <div class="grid grid-cols-3 gap-2 mt-3">
                        @foreach($photos as $photo)
                        <div style="background-image: url('{{ $photo->temporaryUrl() }}'); background-size: cover; background-position: center center;" class="w-full h-21 sm:h-44">
                        </div>
                        @endforeach
                    </div>
                    @endif
                    <x-jet-input-error for="photos.*" class="mt-2" />
                </div>

                <div class="flex justify-end mt-3">
                    <div class="mr-4">
                        <x-jet-secondary-button wire:click="done" class="font-semibold text-red-700">
                            cancel
                        </x-jet-secondary-button>
                    </div>

                    <div>
                        <x-jet-button class="bg-blue-600">
                            <i wire:loading="create" class="font-black fas fa-spin fa-spinner"></i> &nbsp;{{ $type }}
                        </x-jet-button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
