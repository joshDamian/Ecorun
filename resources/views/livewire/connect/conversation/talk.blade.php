<div x-data="{ large_content: false, autosize: function(){

    if(this.$refs.content.value === '') {
    this.$refs.content.classList.add('rounded-full', 'overflow-hidden');
    this.large_content = false;
    } else {
    this.$refs.content.classList.remove('rounded-full', 'overflow-hidden');
    }
    this.$refs.content.style.cssText = 'height:auto;';
    var scrollHeight = this.$refs.content.scrollHeight;
    if(scrollHeight <= 200) {
    this.$refs.content.style.cssText = 'height:' + scrollHeight + 'px;';
    this.large_content = false;
    } else {
    this.large_content = true;
    this.$refs.content.style.cssText = 'height:' + 200 + 'px;';
    }
    } }" x-init="() => {
    Echo.join('private_conversation.{{ $conversation->id }}')
    .here((profiles) => {
    console.log(profiles)
    })
    .joining((profile) => {
    console.log(profile.name + ' just joined');
    })
    .leaving((profile) => {
    console.log(profile.name + ' is leaving');
    })
    .listen('SentMessage', (e) => {
    Livewire.emit('newMessage');
    console.log(e);
    });
    }">
    <div class="sticky flex items-center p-3 bg-gray-100 top-12">
        <div class="mr-3">
            <i onclick="Livewire.emit('showAll'); window.scrollTo(0, 0);"
                class="text-lg text-blue-700 cursor-pointer fas fa-chevron-left"></i>
        </div>

        <div style="background-image: url('{{ $this->partner->profile_photo_url }}'); background-size: cover; background-position: center center;"
            class="w-9 h-9 mr-3 border-t-2 border-b-2 border-blue-700 rounded-full">
        </div>

        <div class="text-lg font-bold text-blue-700">
            {{ $this->partner->full_tag() }}
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 p-3 sm:gap-5 sm:p-5 bg-gradient-to-tl from-gray-300 to-gray-100">
        @foreach($conversation->messages as $message)
        @php $my_message = ($message->sender_id === $me->id) @endphp
        <div class="flex @if($my_message) justify-end @else justify-start @endif font-semibold text-md">
            @if($my_message)
            <div class="flex justify-end w-4/5">
                <x-display-text-content class="p-3 text-white bg-blue-600 rounded-2xl" :content="$message->content" />
            </div>
            @else
            <div class="flex justify-start w-4/5">
                <x-display-text-content class="p-3 text-gray-900 bg-gray-300 rounded-2xl"
                    :content="$message->content" />
            </div>
            @endif
        </div>
        @endforeach
    </div>

    <div class="sticky bottom-0 p-3 bg-gray-100 sm:p-5">
        <form wire:submit.prevent="sendMessage">
            <div :class="large_content ? 'items-end' : 'items-center'" class="flex">
                <div class="flex-1 flex-shrink-0 mr-3">
                    <textarea @input="autosize()" @change="autosize()" @keydown="autosize()" x-ref="content" wire:model.defer="message" rows="1"
                        class="w-full rounded-full form-textarea"></textarea>
                </div>
                <div class="flex-shrink-0">
                    <x-jet-button x-ref="submit" @click="$refs.content.value = ''" class="bg-blue-600 rounded-2xl">
                        send
                    </x-jet-button>
                </div>
            </div>
            <x-jet-input-error for="message" />
        </form>
    </div>
</div>