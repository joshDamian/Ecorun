@props(['photos', 'type'])
<div x-data="{ ready: false }" x-init="() => { Livewire.on('addedContent', () => { ready = false; }) }" x-cloak>
    <div x-show="!ready">
        {{ $trigger }}
    </div>

    <div class="p-4 bg-gray-100 sm:p-6" x-show="ready">
        <form wire:submit.prevent="create">
            @csrf
            <div>
                <div>
                    <div class="flex justify-center w-full text-blue-600" wire:loading>
                        <x-loader_2 />
                    </div>

                    <div class="flex items-baseline justify-between mb-2">
                        <x-jet-label class="mr-5 text-lg font-semibold" value="{{ $type }}" />
                        @error('text_content' ?? 'photos')
                        <div class="text-red-700">
                            please add something!
                        </div>
                        @enderror
                    </div>
                    <textarea autofocus x-ref="content" rows="3" wire:model.defer="text_content"
                        placeholder="say something"
                        class="w-full placeholder-blue-700 rounded-md form-textarea"></textarea>

                    <div class="mt-3">
                        <input class="hidden" x-ref="photos" accept="image/*" type="file" wire:model="photos" multiple>
                        <span @click=" $refs.photos.click() " class="font-semibold text-blue-800 cursor-pointer">
                            <i class="fas fa-images"></i> &nbsp;Photos (Max 5MB)
                        </span>
                        @if(count($photos) > 0)
                        <div class="grid grid-cols-3 gap-2 mt-3">
                            @foreach ($photos as $photo)
                            <div style="background-image: url('{{ $photo->temporaryUrl() }}'); background-size: cover; background-position: center center;"
                                class="w-full h-20 sm:h-36">
                            </div>
                            @endforeach
                        </div>
                        @endif
                        <x-jet-input-error for="photos.*" class="mt-2" />
                    </div>

                    <div class="flex justify-end mt-3">
                        <div class="mr-4">
                            <x-jet-secondary-button @click="ready = false" wire:click="done"
                                class="font-semibold text-red-700">
                                cancel
                            </x-jet-secondary-button>
                        </div>

                        <div>
                            <x-jet-button class="bg-blue-600">
                                <i wire:loading wire:target="create" class="font-black fas fa-spin fa-spinner"></i>
                                &nbsp;{{ $type }}
                            </x-jet-button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
