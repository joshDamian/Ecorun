<div x-data="{ show_me: false, large_content: false, autosize: function(){
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
 }" x-init="() => {
    Echo.join('private_conversation.{{ $conversation->id }}')
    .here((profiles) => {
        console.log(profiles)
    })
    .joining((profile) => {
        console.log(profile.name + ' just joined');
    })
    .leaving((profile) => {
        console.log(profile.name + ' is leaving');
    }).listen('SentMessage', (e) => {
       {{--  Livewire.emit('newSentMessage') --}}
    }).listenForWhisper('typing', () => {
        $refs.status.innerText = 'typing...';
    }).listenForWhisper('done_typing', () => {
        $refs.status.innerText = '';
    });

    Livewire.on('newSentMessage', () =>  {
            window.scrollTo(0, document.body.scrollHeight);
    })
    window.scrollTo(0, document.body.scrollHeight);
}">
    <div class="sticky flex items-center w-full p-3 bg-gray-100 top-12">
        <div class="mr-3">
            <i onclick="Livewire.emit('showAll'); window.modifyUrl.modify('/chat'); "
                class="text-lg text-blue-700 cursor-pointer fas fa-chevron-left"></i>
        </div>

        <div style="background-image: url('{{ $this->partner->profile_photo_url }}'); background-size: cover; background-position: center center;"
            class="mr-3 border-t-2 border-b-2 border-blue-700 rounded-full w-9 h-9">
        </div>

        <div class="grid grid-cols-1 text-lg font-bold text-blue-700">
            {{ $this->partner->full_tag() }}
            <div class="text-xs font-semibold text-blue-500 text-muted" x-ref="status"></div>
        </div>
    </div>

    <div x-ref="messages"
        class="grid grid-cols-1 gap-3 px-3 pt-6 pb-3 sm:px-5 sm:pb-5 sm:gap-5 md:pt-5 bg-gradient-to-tl from-gray-300 to-gray-100">
        @foreach($messages as $message)
        @php $my_message = ($message->sender_id === $me->id) @endphp
        <div id="{{ $message->id }}"
            class="flex @if($my_message) justify-end @else justify-start @endif font-semibold text-md">
            @if($my_message)
            <div class="flex justify-end w-4/5">
                <x-display-text-content class="max-w-full p-3 text-white bg-blue-600 rounded-2xl"
                    :content="$message->content" />
            </div>
            @else
            <div class="flex justify-start w-4/5">
                <x-display-text-content class="max-w-full p-3 text-gray-900 bg-gray-300 break rounded-2xl"
                    :content="$message->content" />
            </div>
            @endif
        </div>
        @endforeach
    </div>

    <div class="sticky bottom-0 p-3 bg-gradient-to-tl from-gray-100 to-gray-300 sm:p-5">
        <div :class="large_content ? 'items-end' : 'items-center'" class="flex">
            <div class="flex-1 flex-shrink-0">
                <x-jet-input autofocus x-show="show_me" class="w-full rounded-full" x-model="message" />
                <textarea x-ref="content" x-show="!show_me" autofocus onfocusout="Echo.join('private_conversation.{{ $conversation->id }}')
                    .whisper('done_typing')" :class="(message === '') ? 'rounded-full overflow-hidden' : 'rounded'"
                    @input="autosize()" @keydown="autosize(); Echo.join('private_conversation.{{ $conversation->id }}')
                    .whisper('typing')" x-ref="content" x-model="message" rows="1"
                    class="w-full resize-none form-textarea"></textarea>
            </div>
            <div x-show="message !== ''" class="flex-shrink-0 ml-3">
                <button
                    class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-blue-600 border border-transparent hover:bg-gray-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 rounded-2xl focus:shadow-outline-gray disabled:opacity-25"
                    @click=" @this.call('sendMessage', message); show_me = true; setTimeout(() => { show_me = false; }, 1000); message = '';">
                    send
                </button>
            </div>
        </div>
        <x-jet-input-error for="message" />
    </div>
</div>
