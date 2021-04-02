@props(['photos', 'type', 'profilePhotoUrl'])
<div x-data="content_data()" x-init="initialize()" x-cloak>
    <div :class="ready ? '' : 'flex items-center'">
        <div x-show="!ready" style="background-image: url('{{ $profilePhotoUrl }}'); background-size: cover; background-position: center
            center;" class="w-10 h-10 mr-3 border-t-2 border-b-2 border-blue-700 rounded-full">
        </div>

        <div class="flex-1">
            <form wire:submit.prevent="create">
                @csrf
                <div>
                    @foreach($this->getErrorBag()->all() as $key => $value)
                    <div>
                        {{ $value }}
                    </div>
                    @endforeach
                </div>
                <div>
                    <div class="flex justify-center w-full mt-2 mb-2 text-blue-600"
                        wire:target="photos, create, videos, audio" wire:loading>
                        <x-loader_2 />
                    </div>

                    <div x-show="ready" class="flex items-baseline justify-between mb-2">
                        <x-jet-label class="mr-5 text-lg font-semibold" value="{{ $type }}" />
                        @error('text_content' ?? 'photos')
                        <div class="text-red-700">
                            please add something!
                        </div>
                        @enderror
                    </div>

                    <div>
                        <textarea wire:ignore id="text_content_" wire:model.defer="text_content" name="text_content"
                            :class="{ 'rounded-full': !ready,  'overflow-hidden': !large_content, 'rounded-full': message.length < 1 }"
                            x-on:focus="ready = true; $refs.content.setSelectionRange(message.length, message.length)"
                            x-ref="content" rows="1" placeholder="say something" x-model="message"
                            class="w-full placeholder-blue-700 bg-gray-200 resize-none form-textarea"></textarea>

                        <div class="mt-2 mb-2" x-show="ready && mentions.length > 0 && mention_matches">
                            <h3 class="mb-1 font-semibold text-blue-600 text-md">profile suggestions:</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-3">
                                <template x-if="mention_matches && mention_matches.length > 0"
                                    x-for="(mention, index) in mentions" :key="index">
                                    <div x-on:click="replaceText('@' + current_mention, '@' + mention.tag);"
                                        class="flex items-center px-2 py-1 bg-gray-100 border border-gray-300 cursor-pointer hover:bg-blue-200">
                                        <div :style="'background-image: url(' + mention.profile_photo_url +'); background-size: cover; background-position: center center;'"
                                            class="flex-shrink-0 mr-2 border-t-2 border-b-2 border-blue-700 rounded-full w-7 h-7">
                                        </div>

                                        <div class="grid grid-cols-1 text-sm font-bold text-blue-700">
                                            <div class="mr-2 truncate" x-text="mention.name"></div>
                                            <div class="flex-shrink-0 -mt-2" x-text="'@' + mention.tag">
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="mt-2 mb-2" x-show="ready && hashtags.length > 0 && hashtag_matches">
                            <h3 class="mb-1 font-semibold text-blue-600 text-md">hashtag suggestions:</h3>
                            <div class="grid grid-cols-1 gap-1 sm:grid-cols-3">
                                <template x-if="hashtag_matches && hashtag_matches.length > 0"
                                    x-for="(hashtag, index) in hashtags" :key="index">
                                    <div x-on:click="replaceText('#' + current_hashtag, event.target.innerText)"
                                        x-text="'#' + hashtag"
                                        class="px-2 py-1 font-bold text-blue-700 bg-gray-100 border border-gray-300 cursor-pointer hover:bg-blue-200">
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div x-show="ready" :class="ready ? 'mt-2' : ''" class="grid grid-cols-1 gap-2">
                        <div>
                            <div class="flex">
                                <div :class="view_status['photos'] ? 'bg-gray-200' : ''"
                                    x-on:click="set_view_status('photos')"
                                    class="px-2 py-1 font-semibold text-blue-800 cursor-pointer select-none">
                                    <i class="fas fa-images"></i> &nbsp;Photos
                                </div>

                                <div :class="view_status['videos'] ? 'bg-gray-200' : ''"
                                    x-on:click="set_view_status('videos')"
                                    class="px-2 py-1 font-semibold text-blue-800 cursor-pointer select-none">
                                    <i class="fas fa-video"></i> &nbsp;Videos
                                </div>

                                <div :class="view_status['audio'] ? 'bg-gray-200' : ''"
                                    x-on:click="set_view_status('audio')"
                                    class="px-2 py-1 font-semibold text-blue-800 cursor-pointer select-none">
                                    <i class="fas fa-microphone"></i> &nbsp;Audio
                                </div>

                                <div :class="view_status['music'] ? 'bg-gray-200' : ''"
                                    x-on:click="set_view_status('music')"
                                    class="px-2 py-1 font-semibold text-blue-800 cursor-pointer select-none">
                                    <i class="fas fa-music"></i> &nbsp;Music
                                </div>
                            </div>

                            <div>
                                <!-- Photo upload -->
                                <div x-show="view_status['photos']">
                                    @if(empty($photos))
                                    <div class="flex items-center justify-center py-4 bg-gray-200">
                                        <x-jet-button type="button" x-on:click="$refs.photos.click()"
                                            class="bg-blue-700 text-md">
                                            select photos &nbsp; <i class="fas fa-images"></i>
                                        </x-jet-button>
                                        <input name="photos" hidden x-ref="photos" accept="image/*" type="file"
                                        wire:model="photos" multiple />
                                    </div>
                                    @else
                                    <div class="p-3 bg-gray-200">
                                        <x-connect.image.multiple-selector :photos="$photos" />
                                        <div class="flex justify-center w-full text-blue-600" wire:target="addedImages"
                                            wire:loading>
                                            <x-loader_2 />
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <!-- Video upload -->
                                <div wire:ignore x-show="view_status['videos']">
                                    <template x-if="!preview_ready['videos']">
                                        <div class="flex items-center justify-center py-4 bg-gray-200">
                                            <x-jet-button type="button" x-on:click="$refs.videos.click()"
                                                class="bg-blue-700 text-md">
                                                select videos &nbsp; <i class="fas fa-video"></i>
                                            </x-jet-button>
                                            <input name="videos"
                                            x-on:change="selectReadDisplay('videos', event.target.files, $refs.videos_preview)"
                                            class="hidden" x-ref="videos" accept="video/*" type="file"
                                            wire:model="videos" multiple />
                                        </div>
                                    </template>
                                    <div wire:ignore x-show="preview_ready['videos']" x-ref="videos_preview"
                                        class="grid grid-cols-2 gap-2 px-3 pb-3 bg-gray-200 sm:grid-cols-3">
                                    </div>
                                </div>

                                <!-- audio upload -->
                                <div x-show="view_status['audio']">
                                    <template x-if="!preview_ready['audio']">
                                        <div class="flex items-center justify-center py-4 bg-gray-200">
                                            <span x-on:click="$refs.recorder.click()"
                                                class="cursor-pointer fa-stack fa-2x">
                                                <i class="text-blue-800 fas fa-circle fa-stack-2x"></i>
                                                <i class="text-white fa-stack-1x fas fa-microphone"></i>
                                            </span>
                                            <input name="recorder"
                                            x-on:change="selectReadDisplay('audio', event.target.files, $refs.audio_preview)"
                                            hidden x-ref="recorder" accept="audio/*" type="file" wire:model=""
                                            capture />
                                        </div>
                                    </template>
                                    <div wire:ignore x-show="preview_ready['audio']" x-ref="audio_preview"
                                        class="px-3 pb-3 bg-gray-200">
                                    </div>
                                </div>

                                <!-- music upload -->
                                <div wire:ignore x-show="view_status['music']">
                                    <div class="flex items-center justify-center py-2 bg-gray-100">
                                        <div class="grid flex-1 gap-3 sm:grid-cols-2">
                                            <!-- Title -->
                                            <div>
                                                <x-jet-label for="music_title" value="Music title" />
                                                <input x-ref="music_title" id="music_title" name="music_title"
                                                class="w-full mt-1 form-input" placeholder="Music title"
                                                wire:model="music.title" />
                                            </div>

                                            <!-- Artiste -->
                                            <div>
                                                <x-jet-label for="music_artiste" value="Artiste" />
                                                <input id="music_artiste" name="music_artiste"
                                                class="w-full mt-1 form-input" placeholder="Artiste"
                                                wire:model.defer="music.artiste" />
                                            </div>

                                            <!-- Cover art -->
                                            <div>
                                                <x-jet-label for="music_cover_art" value="Cover art (optional)" />
                                                <input id="music_cover_art"
                                                x-on:click="clearDisplay($refs.preview_cover_art)"
                                                x-on:change="selectReadDisplay('cover_art', event.target.files, $refs.preview_cover_art)"
                                                accept="image/*" type="file" name="cover_art"
                                                class="w-full mt-1 form-input" placeholder="Artiste"
                                                wire:model.defer="music.cover_art" />
                                                <div x-show="preview_ready['cover_art']" x-ref="preview_cover_art">
                                                </div>
                                            </div>

                                            <!-- Associated acts -->
                                            <div>
                                                <x-jet-label for="associated_acts" value="Associated acts (optional)" />
                                                <input id="associated_acts" name="associated_acts"
                                                class="w-full mt-1 form-input" placeholder="Associated acts"
                                                wire:model.defer="music.associated_acts" />
                                            </div>

                                            <!-- Music lyrics -->
                                            <div>
                                                <x-jet-label for="music_lyrics" value="Lyrics (optional)" />
                                                <textarea id="music_lyrics" rows="3" name="music_lyrics"
                                                    class="w-full mt-1 form-input" placeholder="Lyrics"
                                                    wire:model.defer="music.lyrics"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-center py-4 bg-gray-200">
                                        <x-jet-button type="button" x-on:click="$refs.music.click()"
                                            class="bg-blue-700 text-md">
                                            select music file &nbsp; <i class="fas fa-music"></i>
                                        </x-jet-button>
                                        <input x-on:click="clearDisplay($refs.music_preview)" name="music"
                                        x-on:change="selectReadDisplay('music', event.target.files, $refs.music_preview)"
                                        hidden x-ref="music" accept="audio/*" type="file"
                                        wire:model.defer="music.file" />
                                    </div>
                                    <div wire:ignore x-show="preview_ready['music']" x-ref="music_preview"
                                        class="px-3 pb-3 bg-gray-200">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <template x-if="!edit_case">
                                <div class="mr-4">
                                    <x-jet-secondary-button x-on:click="ready = false; resetHeight()" wire:click="done"
                                        class="font-semibold text-red-700">
                                        cancel
                                    </x-jet-secondary-button>
                                </div>
                            </template>

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
    <script src="/js/create_content.js">
    </script>
</div>