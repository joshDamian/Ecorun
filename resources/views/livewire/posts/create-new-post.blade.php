<div>
    <div class="flex p-2 sm:px-5 sm:py-3 sm:p-0 items-center justify-between @if($ready) border-b @endif border-gray-200">
        <div class="flex items-center">
            <div style="background-image: url('{{ $profile->profile_image() }}'); background-size: cover; background-position: center center;" class="w-14 rounded-full mr-3 h-14">
            </div>
            <span class="text-lg font-medium">{{ $profile->name() }}</span>
        </div>
        <div>
            <x-jet-button wire:click="ready" class="bg-blue-700">
                <i class="fas fa-plus"></i> &nbsp; New post
            </x-jet-button>
        </div>
    </div>
    @if($ready)
    <form wire:submit.prevent="create">
        <div x-data class="p-4">
            <div>
                <div wire:loading class="flex justify-center items-center">
                    <x-loader />
                </div>

                <div class="flex justify-between mb-1 items-baseline">
                    <x-jet-label class="font-semibold text-lg mr-4" value="Post" />
                    @error('content' ?? 'photos')
                    <div class="text-red-700">please add something!</div>
                    @enderror
                </div>
                <textarea rows="4" wire:model.defer="content" placeholder="say something" class="form-textarea w-full"></textarea>

                <div class="mt-2">
                    <input class="hidden" x-ref="photos" accept="image/*" type="file" wire:model="photos" multiple>
                    <span @click=" $refs.photos.click() " class="text-blue-800 cursor-pointer font-semibold">
                        <i class="fas fa-images"></i> &nbsp;Photos
                    </span>
                    @if($photos)
                    <div class="mt-2 grid gap-2 grid-cols-3">
                        @foreach($photos as $photo)
                        <div style="background-image: url('{{ $photo->temporaryUrl() }}'); background-size: cover; background-position: center center;" class="h-20 w-full">
                        </div>
                        @endforeach
                    </div>
                    @endif
                    <x-jet-input-error for="photos.*" class="mt-1" />
                </div>

                <div class="mt-2 flex justify-end">
                    <div class="mr-3">
                        <x-jet-secondary-button wire:click="done" class="bg-red-700">
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
