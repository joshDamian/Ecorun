<div>
    <div class="p-2 sm:p-0 @if($view === 'landing-page') flex sm:px-5 sm:py-3 items-center justify-between @else sm:py-1 @endif @if($ready) border-b @endif border-gray-200">
        @if($view === 'landing-page')
        <div class="flex items-center">
            <div style="background-image: url('{{ $profile->profile_image() }}'); background-size: cover; background-position: center center;" class="w-14 rounded-full mr-3 h-14">
            </div>
            <span class="text-lg font-medium">{{ $profile->name() }}</span>
        </div>
        @endif
        <div>
            <x-jet-secondary-button wire:click="ready" class="text-blue-700">
                <i class="fas fa-plus"></i> &nbsp; New post
            </x-jet-secondary-button>
        </div>
    </div>
    @if($ready)
    <form wire:submit.prevent="create">
        <div x-data class="p-2 @if($view === 'landing-page') sm:px-5 sm:py-3 @else sm:py-1 @endif sm:p-0">

            <div>
                <div class="flex text-blue-600 justify-center" style="width: 100%;" wire:loading>
                    <div class="text-center text-xl">
                        loading &nbsp; <i class="fas fa-spin fa-spinner"></i>
                    </div>
                    {{--  <x-loader /> --}}
                </div>

                <div class="flex justify-between mb-1 items-baseline">
                    <x-jet-label class="font-semibold text-lg mr-4" value="Post" />
                    @error('content' ?? 'photos')
                    <div class="text-red-700">
                        please add something!
                    </div>
                    @enderror
                </div>
                <textarea rows="5" wire:model.defer="content" placeholder="say something" class="form-textarea w-full"></textarea>

                <div class="mt-2">
                    <input class="hidden" x-ref="photos" accept="image/*" type="file" wire:model="photos" multiple>
                    <span @click=" $refs.photos.click() " class="text-blue-800 cursor-pointer font-semibold">
                        <i class="fas fa-images"></i> &nbsp;Photos (Max 5MB)
                    </span>
                    @if($photos)
                    <div class="mt-2 grid gap-2 grid-cols-3">
                        @foreach($photos as $photo)
                        <div style="background-image: url('{{ $photo->temporaryUrl() }}'); background-size: cover; background-position: center center;" class="h-20 sm:h-40 w-full">
                        </div>
                        @endforeach
                    </div>
                    @endif
                    <x-jet-input-error for="photos.*" class="mt-1" />
                </div>

                <div class="mt-2 flex justify-end">
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