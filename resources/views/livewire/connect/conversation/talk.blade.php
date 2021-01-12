<div x-data="{ content: '' ,autosize: function(){
    this.$refs.content.style.cssText = 'height:auto;';
    if($refs.content.value !== '') {
        $refs.content.classList.remove('rounded-full')
    } else {
        $refs.content.classList.add('rounded-full')
    }
    var scrollHeight = this.$refs.content.scrollHeight;
    if(scrollHeight <= 200) {
        this.$refs.content.style.cssText = 'height:' + scrollHeight + 'px;';
    } else {
        this.$refs.content.style.cssText = 'height:' + 200 + 'px;';
    }
} }" x-init="$watch('content' => value {})">
    <div class="sticky flex items-center p-3 bg-gray-100 top-12">
        <div class="mr-3">
            <i onclick="window.scrollTo(0, 0); Livewire.emit('showAll')"
                class="text-xl text-blue-700 cursor-pointer fas fa-chevron-left"></i>
        </div>

        <div style="background-image: url('{{ $this->partner->profile_photo_url }}'); background-size: cover; background-position: center center;"
            class="w-10 h-10 mr-3 border-t-2 border-b-2 border-blue-700 rounded-full">
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
            <div class="flex justify-end w-1/2">
                <x-display-text-content class="p-3 text-white bg-blue-700 rounded-2xl" :content="$message->content" />
            </div>
            @else
            <div class="flex justify-start w-1/2">
                <x-display-text-content class="p-3 text-gray-900 bg-gray-300 rounded-2xl"
                    :content="$message->content" />
            </div>
            @endif
        </div>
        @endforeach
    </div>

    <div class="sticky bottom-0 p-3 bg-gray-100 sm:p-5">
        <form wire:submit.prevent="sendMessage">
            <div class="flex items-center">
                <div class="flex-1 flex-shrink-0 mr-3">
                    <textarea x-model="content" @input="autosize()" x-ref="content" wire:model.defer="message" rows="1"
                        class="w-full rounded-full form-textarea"></textarea>
                </div>
                <div class="flex-shrink-0">
                    <x-jet-button x-ref="submit" @click="$refs.content.value = ''" class="bg-blue-700 rounded-2xl">
                        send
                    </x-jet-button>
                </div>
            </div>
            <x-jet-input-error for="message" class="mt-1" />
        </form>
    </div>
</div>
