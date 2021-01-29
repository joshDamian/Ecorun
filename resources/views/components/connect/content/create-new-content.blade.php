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
    mentions: $wire.entangle('mentions'),
    hashtags: $wire.entangle('hashtags'),
    hashtag_match: /(^|\s)#(\w*(?:\s*\w*))$/,
    mentions_match: /(^|\s)@(\w*(?:\s*\w*))$/,
    hint: function(){
        var mention_matches = this.message.match(this.mentions_match);
        var hashtag_matches = this.message.match(this.hashtag_match);
        if(mention_matches && mention_matches.length > 0) {
            @this.call('hintMentions', mention_matches[0]);
        }
        if(hashtag_matches && hashtag_matches.length > 0) {
            @this.call('hintHashtags', hashtag_matches[0]);
        }
    },
    resetHeight: function(){
        this.message = '';
        this.large_content = false;
        this.$refs.content.style.cssText = 'height:auto;';
        this.$refs.content.rows = '1';
    },
    message: '',
    hashtags_to_display: [],
    mentions_to_display: [],
    large_content: false
    }"
    x-init="() => { Livewire.on('addedContent', () => { ready = false; resetHeight(); }); $watch('ready', value =>  Livewire.emit('toggled', ready)); $watch('mentions', value => { mentions_to_display = JSON.parse(value); console.log(mentions_to_display) } ); $watch('hashtags', value => { hashtags_to_display = JSON.parse(value); console.log(hashtags_to_display) } ) }"
    x-cloak>
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

                    <div>
                        <textarea
                            :class="{ 'rounded-full': !ready,  'overflow-hidden': !large_content, 'rounded-full': message === '' }"
                            @focus="ready = true" x-ref="content" rows="1" wire:model.defer="text_content"
                            placeholder="say something" x-model="message" @input="autosize(); hint()"
                            @keydown="autosize();"
                            class="w-full placeholder-blue-700 resize-none form-textarea"></textarea>
                        <template x-if="mentions_to_display.length > 0">
                            <div>
                                <template x-for="mention in mentions_to_display" :key="mention.id">
                                    <div x-text="mention.name" class="p-3 font-bold text-blue-700"></div>
                                </template>
                            </div>
                        </template>

                        <div>
                            <template x-if="hashtags_to_display.length > 0">
                                <div>
                                    <template x-for="hashtag in hashtags_to_display" :key="hashtag.id">
                                        <div x-text="'#' + hashtag.slug.en" class="p-3 font-bold text-blue-700"></div>
                                    </template>
                                </div>
                            </template>
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
