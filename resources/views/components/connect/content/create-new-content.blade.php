@props(['photos', 'type', 'profilePhotoUrl'])
<div x-data="{ ready: false, autosize: function(){
    this.$refs.content.style.cssText = 'height:auto;';
    var scrollHeight = this.$refs.content.scrollHeight;
    if(scrollHeight <= 140) {
    this.$refs.content.style.cssText = 'height:' + scrollHeight + 'px;';
    this.large_content = false;
    } else {
    this.$refs.content.style.cssText = 'height:' + 140 + 'px;';
    this.large_content = true;
    }
    },
    mentions: [],
    hashtags: [],
    hashtag_match: /(^|\s)#([A-Za-z0-9_-]{1,100}(?!\w))$/,
    mentions_match: /(^|\s)@([A-Za-z0-9_-]{1,30}(?!\w))$/,
    mention_matches: [],
    hashtag_matches: [],
    match: function(){
    this.mention_matches = this.message.match(this.mentions_match);
    this.hashtag_matches = this.message.match(this.hashtag_match);
    },
    resetHeight: function(){
    this.message = '';
    this.large_content = false;
    this.$refs.content.style.cssText = 'height:auto;';
    this.$refs.content.rows = '1';
    },
    message: '',
    replaceText: function(initial, replacement) {
    var value = this.message.replace(new RegExp(initial + '$'), replacement + ' ');
    this.$refs.content.value = value;
    console.log(this.$refs.content.value)
    },
    current_mention: '',
    current_hashtag: '',
    large_content: false
    }" x-init="() => {
    Livewire.on('addedContent', () => {
    ready = false; resetHeight();
    });
    $watch('ready', value => { Livewire.emit('toggled', ready); if(!value) mentions = []; hashtags = [] });

    /** autosuggest mentions **/
    $watch('mention_matches', value => {
    if(value && value.length > 0) {
    current_mention = value[2];
    return $wire.hintMentions(current_mention).then(result => { mentions = result });
    } else {
    current_mention = '';
    mentions = [];
    }
    });

    /** autosuggest hashtags **/
    $watch('hashtag_matches', value => {
    if(value && value.length > 0) {
    current_hashtag = value[2];
    $wire.hintHashtags(current_hashtag).then(result => { hashtags = result });
    } else {
    current_hashtag = '';
    hashtags = [];
    }
    });

    /** watch message **/
    $watch('message', value => {
    if(value !== '') {
    autosize();
    match();
    }
    })
    }" x-cloak>
    <div :class="ready ? '' : 'flex items-center'">
        <div x-show="!ready"
            style="background-image: url('{{ $profilePhotoUrl }}'); background-size: cover; background-position: center center;"
            class="w-10 h-10 mr-3 border-t-2 border-b-2 border-blue-700 rounded-full">
        </div>

        <div class="flex-1">
            <form wire:submit.prevent="create">
                @csrf
                <div>
                    <div class="flex justify-center w-full text-blue-600" wire:target="photos, create" wire:loading>
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

                    <div wire:ignore class="relative">
                        <textarea
                            :class="{ 'rounded-full': !ready,  'overflow-hidden': !large_content, 'rounded-full': message === '' }"
                            @focus="ready = true; $refs.content.setSelectionRange(message.length, message.length)"
                            x-ref="content" rows="1" wire:model.defer="text_content" placeholder="say something"
                            x-model="message" class="w-full placeholder-blue-700 resize-none form-textarea"></textarea>
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
                            <div class="flex">
                                <template x-if="hashtag_matches && hashtag_matches.length > 0"
                                    x-for="(hashtag, index) in hashtags" :key="index">
                                    <div :class="{ 'flex-grow': hashtags.length > 1, 'mr-2': index !== hashtags.length - 1 }"
                                        x-on:click="replaceText('#' + current_hashtag, event.target.innerText)"
                                        x-text="'#' + hashtag"
                                        class="px-2 py-1 font-bold text-blue-700 bg-gray-100 border border-gray-300 cursor-pointer hover:bg-blue-200">
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div x-show="ready" :class="ready ? 'mt-2' : ''" class="grid grid-cols-1 gap-2">
                        <div>
                            <input class="hidden" x-ref="photos" accept="image/*" type="file" wire:model="photos"
                            multiple>
                            <span @click="$refs.photos.click()"
                                class="font-semibold text-blue-800 cursor-pointer select-none">
                                <i class="fas fa-images"></i> &nbsp;Photos (Max 10MB)
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

                        <div class="flex justify-end">
                            <div class="mr-4">
                                <x-jet-secondary-button @click="ready = false; resetHeight()" wire:click="done"
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
</div>