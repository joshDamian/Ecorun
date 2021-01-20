<div x-data="{ large_content: false, autosize: function(){
        this.$refs.content.style.cssText = 'height:auto;';
        var scrollHeight = this.$refs.content.scrollHeight;
        if(scrollHeight <= 140) {
            this.$refs.content.style.cssText = 'height:' + scrollHeight + 'px;';
            this.large_content = false;
        } else {
            this.large_content = true;
            this.$refs.content.style.cssText = 'height:' + 140 + 'px;';
        }
    },
    message: '',
    resetHeight: function(){
        this.large_content = false;
        this.$refs.content.style.cssText = 'height:auto;';
        this.message = '';
        this.$refs.content.focus();
        this.$refs.content.rows = '1';
    }
}" x-init="() => {
    Livewire.emit('hide', true);
    Echo.join('private_conversation.{{ $conversation->id }}')
    .here((profiles) => {
        console.log(profiles);
        @this.call('markReceivedMessagesRead');
    })
    .joining((profile) => {
        console.log(profile.name + ' just joined');
        @this.call('markReceivedMessagesRead');
    })
    .leaving((profile) => {
        console.log(profile.name + ' is leaving');
    }).listen('SentMessage', (e) => {
        @this.call('$refresh')
        Livewire.hook('element.initialized', (el, compo) => {
            if((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                window.scrollTo(0, document.body.scrollHeight);
            }
        })
        @this.call('markReceivedMessagesRead');
    }).listenForWhisper('typing', () => {
        $refs.status.innerText = 'typing...';
    }).listenForWhisper('done_typing', () => {
        $refs.status.innerText = '';
    }).listenForWhisper('readMessages', () => {
        @this.call('$refresh')
    });
    Livewire.on('SentAMessage', () =>  {
        window.scrollTo(0, document.body.scrollHeight);
    })
    Livewire.on('readMessages', () => {
        Echo.join('private_conversation.{{ $conversation->id }}')
        .whisper('readMessages')
    })
    window.scrollTo(0, $refs.messages.scrollHeight);
}" x-cloak>
    <div class="fixed top-0 flex items-center w-full p-3 bg-gray-100 md:sticky md:top-12">
        <div class="mr-3">
            <i @click="Livewire.emit('showAll'); window.modifyUrl.modify('/chat'); Livewire.emit('hide', false);"
                class="text-xl text-blue-700 cursor-pointer fas fa-arrow-left"></i>
        </div>

        <div style="background-image: url('{{ $this->partner->profile_photo_url }}'); background-size: cover; background-position: center center;"
            class="flex-shrink-0 mr-3 border-t-2 border-b-2 border-blue-700 rounded-full w-9 h-9">
        </div>

        <div class="grid flex-shrink-0 grid-cols-1 text-lg font-bold text-blue-700">
            {{ $this->partner->full_tag() }}
            <div class="text-xs font-semibold text-blue-500 text-muted" x-ref="status"></div>
        </div>

        <div class="flex items-center justify-end flex-1 flex-shrink-0 ml-2 justify-self-end">
            <i onclick="window.scrollTo(0, 0)" title="jump to top"
                class="mr-4 text-xl text-blue-700 cursor-pointer fas fa-arrow-up"></i>
            <i onclick="window.scrollTo(0, document.body.scrollHeight)" title="jump to bottom"
                class="text-xl text-blue-700 cursor-pointer fas fa-arrow-down"></i>
        </div>
    </div>

    <div style="scroll-behavior: auto;" x-ref="messages"
        class="grid grid-cols-1 gap-3 px-3 pt-6 pb-2 sm:pb-5 sm:px-5 sm:gap-5 md:pt-6 bg-gradient-to-tl from-gray-300 to-gray-100">
        @if($messages_count > $messages->count())
        <div class="flex justify-center">
            <x-jet-button wire:click="loadOlderMessages" class="bg-blue-700 rounded-xl">
                load older messages
            </x-jet-button>
        </div>
        @endif
        @foreach($messages as $key => $message)
        @php
        $my_message = ($message->sender_id === $me->id);
        @endphp
        @if($message !== $messages->first() && ($message->created_at->day > $messages->get($key -
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
        <div id="{{ $message->id }}"
            class="flex @if($my_message) justify-end @else justify-start @endif font-semibold text-md">
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
        @endforeach
    </div>

    <div class="sticky bottom-0 w-full p-2 bg-gradient-to-tl from-gray-100 to-gray-300 sm:p-3">
        <div :class="large_content ? 'items-baseline' : 'items-center'" class="flex">
            <div class="flex items-center mr-3 text-2xl text-blue-700">
                <i class="cursor-pointer far fa-images"></i>
            </div>
            <div class="flex-1 flex-shrink-0">
                <textarea x-ref="content" x-model="message" onfocusout="Echo.join('private_conversation.{{ $conversation->id }}')
                        .whisper('done_typing')"
                    :class="(message === '') ? 'rounded-full overflow-hidden' : 'rounded-md'"
                    placeholder="Type a message" @input="autosize()" @keydown="autosize(); Echo.join('private_conversation.{{ $conversation->id }}')
                        .whisper('typing')" rows="1"
                    class="w-full placeholder-blue-700 resize-none form-textarea"></textarea>
            </div>

            <div x-show="message !== ''" class="flex-shrink-0 ml-3">
                <button
                    class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-blue-600 border border-transparent hover:bg-gray-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 rounded-2xl focus:shadow-outline-gray disabled:opacity-25"
                    @click=" @this.call('sendMessage', message); resetHeight()">
                    send
                </button>
            </div>
        </div>
        <x-jet-input-error for="message" />
    </div>
</div>
