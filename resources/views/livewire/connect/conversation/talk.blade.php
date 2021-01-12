<div>
    <div class="flex items-center p-3 bg-gray-100">
        <div class="mr-3">
            <i onclick="Livewire.emit('showAll')" class="text-xl text-blue-700 cursor-pointer fas fa-chevron-left"></i>
        </div>

        <div style="background-image: url('{{ $this->partner->profile_photo_url }}'); background-size: cover; background-position: center center;"
            class="w-10 h-10 mr-3 border-t-2 border-b-2 border-blue-700 rounded-full">
        </div>

        <div class="text-lg font-bold text-blue-700">
            {{ $this->partner->full_tag() }}
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 p-3 bg-gradient-to-tl from-gray-300 to-gray-200">
        @foreach($conversation->messages as $message)
        @php $my_message = ($message->sender_id === $me->id) @endphp
        <div class="flex @if($my_message) justify-end @else justify-start @endif">
            @if($my_message)
            <div class="flex justify-end w-1/2">
                <x-display-text-content class="p-4 text-white bg-blue-700 break-long-words rounded-3xl"
                    :content="$message->content" />
            </div>
            @else
            <div class="flex justify-start w-1/2">
                <x-display-text-content class="p-4 text-white bg-purple-700 break-long-words rounded-3xl"
                    :content="$message->content" />
            </div>
            @endif
        </div>
        @endforeach
    </div>

    <form wire:submit.prevent="sendMessage">
        <div class="p-3 bg-gray-100">
            <textarea wire:model="message" class="w-full rounded-3xl form-textarea"></textarea>
            <x-jet-input-error for="message" class="mt-2" />
            <div class="mt-2 text-right">
                <x-jet-button class="bg-blue-700">
                    send
                </x-jet-button>
            </div>
        </div>
    </form>
</div>
