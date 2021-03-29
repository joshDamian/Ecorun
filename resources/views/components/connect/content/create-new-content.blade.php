@props(['photos', 'type', 'profilePhotoUrl'])
<div x-data="content_data()" x-init="initialize()" x-cloak>
    <div :class="ready ? '' : 'flex items-center'">
        <div x-show="!ready"
            style="background-image: url('{{ $profilePhotoUrl }}'); background-size: cover; background-position: center center;"
            class="w-10 h-10 mr-3 border-t-2 border-b-2 border-blue-700 rounded-full">
        </div>

        <div class="flex-1">
            <form wire:submit.prevent="create">
                @csrf
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
                            @focus="ready = true; $refs.content.setSelectionRange(message.length, message.length)"
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
                                <div :class="view_status['photos'] ? 'bg-gray-200' : ''" x-on:click="set_view_status('photos')"
                                    class="font-semibold px-2 py-1 text-blue-800 cursor-pointer select-none">
                                    <i class="fas fa-images"></i> &nbsp;Photos
                                </div>


                                <div :class="view_status['videos'] ? 'bg-gray-200' : ''" x-on:click="set_view_status('videos')"
                                    class="font-semibold px-2 py-1 text-blue-800 cursor-pointer select-none">
                                    <i class="fas fa-video"></i> &nbsp;Videos
                                </div>

                                <div x-on:click="" class="font-semibold px-2 py-1 text-blue-800 cursor-pointer select-none">
                                    <i class="fas fa-microphone"></i> &nbsp;Audio
                                </div>

                                <div x-on:click="" class="font-semibold px-2 py-1 text-blue-800 cursor-pointer select-none">
                                    <i class="fas fa-music"></i> &nbsp;Music
                                </div>
                            </div>

                            <div>

                                <div x-show="view_status['photos']">
                                    @if(empty($photos))
                                    <div class="items-center py-5 flex justify-center bg-gray-200">
                                        <x-jet-button type="button" x-on:click="$refs.photos.click()" class="bg-blue-700">
                                            select photos
                                        </x-jet-button>
                                        <input name="photos" hidden x-ref="photos" accept="image/*" type="file"
                                        wire:model="photos" multiple />
                                    </div>
                                    @else
                                    <div class="bg-gray-200 px-1 py-2">
                                        <x-connect.image.multiple-selector :photos="$photos" />
                                    </div>
                                    @endif
                                </div>



                                <div wire:ignore x-show="view_status['videos']">
                                    <template x-if="!preview_videos">
                                        <div class="flex justify-center bg-gray-200 items-center py-5">
                                            <x-jet-button type="button" x-on:click="$refs.videos.click()" class="bg-blue-700">
                                                select videos
                                            </x-jet-button>
                                            <input name="videos" x-on:change="select_videos" class="hidden" x-ref="videos" accept="video/*" type="file"
                                            wire:model="videos" multiple />
                                        </div>
                                    </template>
                                    <div wire:ignore x-show="preview_videos" x-ref="videos_preview"
                                        class="grid grid-cols-2 gap-2 py-2 px-1 bg-gray-200 sm:grid-cols-3"></div>
                                </div>


                            </div>

                            <div class="flex justify-center w-full text-blue-600" wire:target="addedImages"
                                wire:loading>
                                <x-loader_2 />
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
    <script>
        function content_data() {
            return {
                ready: true,
                edit_case: false,
                preview_videos: false,
                message: '',
                view_status: {
                    videos: false,
                    photos: false,
                    audio: false,
                    music: false,
                },
                set_view_status: function(view) {
                    for (index in this.view_status) {
                        if (index === view) {
                            this.view_status[index] = true;
                            continue;
                        }
                        this.view_status[index] = false;
                    }
                    return;
                },
                current_mention: '',
                current_hashtag: '',
                large_content: false,
                mentions: [],
                hashtags: [],
                hashtag_match: /(^|\s)#([A-Za-z0-9_-]{1,100}(?!\w))$/,
                mentions_match: /(^|\s)@([A-Za-z0-9_-]{1,30}(?!\w))$/,
                mention_matches: [],
                hashtag_matches: [],
                match: function() {
                    this.mention_matches = this.message.match(this.mentions_match);
                    this.hashtag_matches = this.message.match(this.hashtag_match);
                },
                resetHeight: function() {
                    this.message = '';
                    this.large_content = false;
                    this.$refs.content.style.cssText = 'height:auto;';
                    this.$refs.content.rows = '1';
                },
                replaceText: function(initial, replacement) {
                    let setMessage = new Promise((resolve, reject) => {
                        if (this.message !== '') {
                            this.message = this.message.replace(new RegExp(initial + '$'), replacement + ' ');
                            this.$refs.content.focus();
                            resolve(this.message);
                        } else {
                            reject('couldn\'t update message property');
                        }
                    });
                    setMessage.then(result => {
                        setTimeout(() => {
                            document.getElementById('text_content_').dispatchEvent(new Event('input'))
                        }, 50);
                    }).catch(x => console.error(x))
                },
                initialize: function() {
                    var type = '{{$type}}';
                    this.edit_case = (type.match('edit'));
                    if (this.edit_case) {
                        this.ready = true;
                        this.message = this.$wire.text_content;
                        window.addEventListener('DOMContentLoaded', () => {
                            this.$refs.content.style.cssText = 'height:' + this.$refs.content.scrollHeight + 'px;';
                        })
                    }
                    window.addEventListener('DOMContentLoaded', () => {
                        /* this.$refs.content.select();
                        if (!this.edit_case) {
                            this.ready = false;
                        } */
                    })
                    Livewire.on('addedContent',
                        () => {
                            this.ready = false;
                            this.resetHeight();
                        });

                    this.$watch('ready',
                        value => {
                            Livewire.emit('toggled', this.ready);
                            if (!value) {
                                this.mentions = [];
                                this.hashtags = []
                            }
                        });
                    /** autosuggest mentions **/
                    this.$watch('mention_matches',
                        value => {
                            if (value && value.length > 0) {
                                this.current_mention = value[2];
                                this.$wire.hintMentions(this.current_mention).then(result => {
                                    this.mentions = result
                                });
                            } else {
                                this.current_mention = '';
                                this.mentions = [];
                            }
                        }
                    );
                    /** autosuggest hashtags **/
                    this.$watch('hashtag_matches',
                        value => {
                            if (value && value.length > 0) {
                                this.current_hashtag = value[2];
                                this.$wire.hintHashtags(this.current_hashtag).then(result => {
                                    this.hashtags = result
                                });
                            } else {
                                this.current_hashtag = '';
                                this.hashtags = [];
                            }
                        }
                    );

                    /** watch message **/
                    this.$watch('message',
                        value => {
                            window.UiHelpers.autosizeTextarea(this.$refs.content, 140)
                            if (value !== '') {
                                this.ready = true;
                                this.match();
                            }
                            if (this.$refs.content.scrollHeight > 140) {
                                this.large_content = true;
                            } else {
                                this.large_content = false;
                            }
                        }
                    );
                },
                select_videos: function () {
                    let videos = this.$refs.videos.files;
                    if (videos.length > 0) {
                        this.preview_videos = true;
                        for (const video in videos) {
                            if (Object.hasOwnProperty.call(videos, video)) {
                                //grab file
                                const video_file = videos[video];

                                // create elements
                                let video_tag = document.createElement('video');
                                let div_element = document.createElement('div');
                                let name_card = document.createElement('div');
                                let progress_bar = document.createElement('progress');
                                name_card.innerText = video_file.name;
                                name_card.classList.add('px-2', 'py-1', 'bg-white', 'mt-2', 'truncate', 'dont-break-out');
                                div_element.classList.add('p-2', 'bg-gray-100');
                                div_element.setAttribute('wire:ignore', true);
                                video_tag.classList.add('w-full');
                                progress_bar.classList.add('pt-2');

                                // append elements to DOM
                                div_element.appendChild(video_tag);
                                div_element.appendChild(progress_bar);
                                div_element.appendChild(name_card);
                                this.$refs.videos_preview.appendChild(div_element);

                                //read file
                                let readFile = new Promise((resolve, reject) => {
                                    let reader = new FileReader();
                                    reader.onload = (event) => {
                                        let src = event.target.result;
                                        if (src !== '') {
                                            resolve(src);
                                            progress_bar.classList.add('hidden');
                                            progress_bar.value = 0;
                                            reader = null;
                                        } else {
                                            reject('couldn\'t read file properly');
                                        }
                                    };
                                    reader.onprogress = (event) => {
                                        if (event.total && event.loaded) {
                                            progress_bar.value = Math.round((event.loaded / event.total) * 100)
                                        }
                                    }
                                    reader.readAsDataURL(video_file);
                                });
                                readFile.then(result => {
                                    video_tag.setAttribute('src', result);
                                    video_tag.setAttribute('controls', true);
                                }).catch(error => console.error(error));
                            }
                        }
                    }
                    return;
                }
            }
        }
    </script>
</div>