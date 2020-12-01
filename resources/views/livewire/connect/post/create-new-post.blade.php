<div>
    <div class="p-2 sm:p-0 @if($view === 'landing-page') flex sm:px-5 sm:py-3 items-center justify-between @else sm:py-1 @endif @if($ready) border-b @endif border-gray-200">
        @if($view === 'landing-page')
        <div class="flex items-center">
            <div style="background-image: url('{{ $profile->profile_image() }}'); background-size: cover; background-position: center center;" class="mr-3 rounded-full w-14 h-14">
            </div>
            <span class="text-lg font-medium">{{ $profile->name() }}</span>
        </div>
        @endif
        <div class="ml-1 md:ml-0">
            <x-jet-secondary-button wire:click="ready" class="text-blue-700">
                <i class="fas fa-plus"></i> &nbsp; New post
            </x-jet-secondary-button>
        </div>
    </div>
    @if($ready)
    <form wire:submit.prevent="create">
        <div x-data class="p-2 @if($view === 'landing-page') sm:px-5 sm:py-3 @else sm:py-1 mx-1 md:mx-0 @endif sm:p-0">
            <div>
                <div class="flex justify-center text-blue-600" style="width: 100%;" wire:loading>
                    <div class="text-xl text-center">
                        loading &nbsp; <i class="fas fa-spin fa-spinner"></i>
                    </div>
                    {{-- <x-loader /> --}}
                </div>

                <div class="flex items-baseline justify-between mb-1">
                    <x-jet-label class="mr-4 text-lg font-semibold" value="Post" />
                    @error('content' ?? 'photos')
                    <div class="text-red-700">
                        please add something!
                    </div>
                    @enderror
                </div>
                <textarea rows="5" wire:model.defer="content" placeholder="say something" class="w-full form-textarea"></textarea>

                <div class="mt-2">
                    <input class="hidden" x-ref="photos" accept="image/*" type="file" wire:model.defer="photos" multiple>
                    
                    <span @click=" $refs.photos.click() " class="font-semibold text-blue-800 cursor-pointer">
                        <i class="fas fa-images"></i> &nbsp;Photos (Max 5MB)
                    </span>

                    @if($photos)
                    <div class="grid grid-cols-3 gap-2 mt-2">
                        @foreach($photos as $photo)
                        <div style="background-image: url('{{ $photo->temporaryUrl() }}'); background-size: cover; background-position: center center;" class="w-full h-20 sm:h-40">
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <x-jet-input-error for="photos.*" class="mt-1" />
                </div>

                <div class="flex justify-end mt-2">
                    <div class="mr-3">
                        <x-jet-secondary-button wire:click="done" class="bg-blue-800">
                            <span class="text-white">cancel</span>
                        </x-jet-secondary-button>
                    </div>

                    <div>
                        <x-jet-button class="bg-blue-600">
                            <i class="fas fa-save"></i> &nbsp;Post
                        </x-jet-button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endif
</div>
