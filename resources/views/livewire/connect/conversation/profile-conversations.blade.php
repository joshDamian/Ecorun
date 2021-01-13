<div class="leading-snug">
    <div wire:loading class="w-full">
        <x-loader_2 />
    </div>
    @if($activeConversation)
    @livewire('connect.conversation.talk', ['me' => $profile, 'conversation' => $activeConversation])
    @else
    <div class="grid grid-cols-1 gap-2 bg-gray-200">
        @foreach($this->current_conversations as $conversation)
        @php
        $last_message = $conversation->messages->last();
        $unread_count = $conversation->getUnreadFor($profile);
        @endphp
        @if($conversation instanceof \App\Models\DirectConversation)
        @php $partner = $conversation->pair->firstWhere('id', '!==', $profile->id); @endphp
        <div wire:click="switchActiveConv('{{ $conversation->id }}')"
            class="flex items-center select-none px-3 py-2 bg-gray-100 cursor-pointer">
            <div style="background-image: url('{{ $partner->profile_photo_url }}'); background-size: cover; background-position: center center;"
                class="flex-shrink-0 w-12 h-12 mr-3 border-t-2 border-b-2 border-blue-700 rounded-full">
            </div>

            <div class="grid flex-1 flex-shrink-0 grid-cols-1">
                <div class="flex @if($unread_count > 0) items-center @else items-start @endif justify-between">
                    <div class="flex-1 flex-shrink-0 font-semibold text-blue-700 truncate">
                        {{ $partner->full_tag() }}
                        <div class="font-medium text-gray-900 truncate">
                            {{ $last_message->content }}
                        </div>
                    </div>

                    <div class="flex-shrink-0 font-medium text-gray-800">
                        <div class="text-center">
                            {{ $conversation->updated_at->diffForHumans(null, true, true) }}
                        </div>
                        @if($unread_count > 0)
                        <span class="fa-stack fa-1x">
                            <i style="font-size: 23px;" class="text-red-600 far fa-circle fa-stack-1x"></i>
                            <span class="text-xs font-extrabold text-red-600 fa-stack-1x">{{ $unread_count  }}</span>
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @continue
        @endif
        @endforeach
    </div>
    @endif
</div>