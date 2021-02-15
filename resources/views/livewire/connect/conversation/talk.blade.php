<div x-data="{
    large_content: false,
    message: '',
    show_options: false,
    show_images: false,
    isSticky: true,
    chatBox: window.ChatBox.build({
    conversation_id: '{{ $conversation->id }}',
    whispers_callback: {
    typing_callback: () => {
    return document.getElementById('status_for_chat_box').innerText = 'typing...'
    },
    doneTyping_callback: () => {
    return document.getElementById('status_for_chat_box').innerText = ''
    },
    readMessages_callback: () => {
    return Livewire.emit('reloadMessages');
    }
    },
    messages_cont: document.getElementById('messages_cont'),
    }),

    resetHeight: function() {
    this.message = '';
    this.show_images = false;
    this.large_content = false;
    this.$refs.content.style.cssText = 'height:auto;';
    this.$refs.content.rows = '1';
    },

    /** x-init **/
    initialize_chat_box: function() {
    Livewire.on('readMessages', () => {
    this.chatBox.whisper('readMessages')
    })

    window.addEventListener('DOMContentLoaded', (event) => {
    history.scrollRestoration = 'manual';
    this.chatBox.goToBottom();
    });
    this.$watch('message', value => {
    window.UiHelpers.autosizeTextarea(this.$refs.content, 140)

    if(this.chatBox.atBottom()) {
    this.chatBox.goToBottom();
    }
    this.chatBox.whisper('typing');

    if(this.$refs.content.scrollHeight > 140) {
    this.large_content = true;
    } else {
    this.large_content = false;
    }
    });
    }
    }" class="bg-gradient-to-tl from-gray-300 to-gray-100" x-init="initialize_chat_box()">
    <div class="fixed top-0 z-40 w-full px-3 py-2 bg-gray-100 md:sticky md:top-12">
        <div class="flex items-center">
            <div class="mr-3">
                <i x-on:click="chatBox.close();" class="text-lg text-blue-700 cursor-pointer fas fa-arrow-left"></i>
            </div>
            <div style="background-image: url('{{ $this->partner->profile_photo_url }}'); background-size: cover; background-position: center center;"
                class="flex-shrink-0 mr-3 border-t-2 border-b-2 border-blue-700 rounded-full w-8 h-8">
            </div>
            <div class="grid flex-shrink line-clamp-1 grid-cols-1 text-lg font-bold text-blue-700">
                {{ $this->partner->full_tag() }}
                <div id="status_for_chat_box" class="text-xs font-bold text-blue-600 text-muted" x-ref="status"></div>
            </div>
            <div class="flex items-center justify-end flex-1 flex-shrink-0 ml-2 justify-self-end">
                <i x-on:click="chatBox.goToTop()" title="jump to top"
                    class="mr-4 text-lg text-gray-600 cursor-pointer fas fa-arrow-up"></i>
                <i x-on:click="chatBox.goToBottom()" title="jump to bottom"
                    class="text-lg text-gray-600 cursor-pointer fas mr-10 fa-arrow-down"></i>
                <i x-on:click="show_options = !show_options" class="text-lg text-blue-700 cursor-pointer fas fa-ellipsis-v"></i>
            </div>
        </div>

        <template x-if="show_options">
            <div class="mt-2 grid grid-cols-1 text-blue-700 bg-gray-200">
                <a class="px-4 py-2 font-semibold text-md" href="{{ $this->partner->url->visit }}">
                    <i class="far fa-user"></i> &nbsp; View profile
                </a>
            </div>
        </template>
    </div>

    <div id="messages_cont" x-ref="messages"
        class="px-3 h-screen overflow-y-auto grid flex-1 grid-cols-1 gap-3 pt-3 pb-5 sm:pb-5 sm:px-5 sm:gap-5 md:pt-6 bg-gradient-to-tl from-gray-300 to-gray-100">
        <div>
            @if($messages_count > $messages->count())
            <div class="flex justify-center">
                <x-jet-button wire:click="loadOlderMessages" class="bg-blue-700 rounded-xl">
                    load older messages
                </x-jet-button>
            </div>
            @endif
        </div>
        @forelse($messages as $key => $message)
        <div>
            @php
            $my_message = ($message->sender_id === $me->id);
            @endphp
            <div>
                @if($message !== $messages->first() && is_object($messages->get($key - 1)) && ($message->created_at->day
                >
                $messages->get($key -
                1)->created_at->day))
                <div class="p-3 font-black text-center text-blue-700 uppercase bg-gray-300 text-md">
                    @if($message->created_at->day === now()->day)
                    {{ __('Today') }}
                    @elseif($message->created_at->day === now()->subDay(1)->day)
                    {{ __('Yesterday') }}
                    @else
                    {{ $message->created_at->isoFormat('Do MMMM YYYY') }}
                    @endif
                </div>
                @endif
            </div>
            <div class="flex @if($my_message) justify-end @else justify-start @endif font-semibold text-md">
                @if($my_message)
                <div class="flex justify-end w-4/5 break-words">
                    <x-connect.message.message-display-card :message="$message" :senderView="true" />
                </div>
                @else
                <div class="flex justify-start w-4/5 break-words">
                    <x-connect.message.message-display-card :message="$message" :senderView="false" />
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="p-4 text-blue-700">
            <div class="flex justify-center items-center">
                <i style="font-size: 6rem;" class="far fa-comment-alt"></i>
            </div>
            <div class="text-center mt-4 font-bold">
                it's quiet in here.
            </div>
        </div>
        @endforelse
    </div>

    <div id="text_box_container" :class="{ 'sticky': isSticky }"
        class="z-40 bottom-0 p-2 bg-gradient-to-tl from-gray-100 to-gray-300 sm:p-3">
        @if(count(config('chatbox.errors.media_messages')) === 0)
        <div wire:loading class="w-full" wire:target="photos, uploadPhotos">
            <x-loader_2 />
        </div>
        @endif

        <div :class="large_content ? 'items-baseline' : 'items-center'" class="flex">
            @if(count(config('chatbox.errors.media_messages')) === 0)
            @php $photos_count = count($photos); @endphp
            <input x-on:change="if(event.target.files.length > 0) { large_content = true; show_images = true; }"
            name="photos" class="hidden" x-ref="photos" accept="image/*" type="file" wire:model="photos" multiple />
            @if($photos_count === 0)
            <div class="flex items-center mr-3 text-2xl text-blue-700">
                <i x-on:click="$refs.photos.click()" class="cursor-pointer far fa-images"></i>
            </div>
            @endif
            @endif

            <div class="flex-1 flex-shrink-0">
                <textarea wire:ignore name="content" x-model="message" wire:model="message_to_send"
                    id="textarea_for_chat_box"
                    x-on:focus="if(chatBox.atBottom()) { setTimeout(() => { chatBox.goToBottom() }, 300) }"
                    x-ref="content" x-on:focusout="chatBox.whisper('doneTyping')"
                    :class="{ 'overflow-hidden': !large_content, 'rounded-full': message === '' }"
                    placeholder="Type a message" rows="1"
                    class="w-full placeholder-blue-700 resize-none form-textarea"></textarea>

                @if(count(config('chatbox.errors.media_messages')) === 0)
                <div x-show="show_images" class="mt-2">
                    @if($photos_count > 0)
                    <x-connect.image.multiple-selector :photos="$photos" />
                    @endif
                </div>
                @endif
            </div>

            <div x-show="message.trim() !== '' || ({{ count($photos) }} > 0)" class="flex-shrink-0 ml-3">
                <button
                    class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-blue-600 border border-transparent hover:bg-gray-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 rounded-2xl focus:shadow-outline-gray disabled:opacity-25"
                    x-on:click="$refs.content.focus(); $wire.sendMessage().then(result => { resetHeight(); chatBox.goToBottom() });">
                    send
                </button>
            </div>
        </div>
        <x-jet-input-error for="message_to_send" />
    </div>
</div>