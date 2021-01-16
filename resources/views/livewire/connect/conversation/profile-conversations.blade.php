<div class="leading-snug">

    @if($activeConversation)
    @livewire('connect.conversation.talk', ['me' => $profile, 'conversation' => $activeConversation])
    @else
    <div class="grid grid-cols-1 gap-1 bg-gray-200">
        <div
            class="sticky w-full p-3 text-lg font-semibold text-blue-700 bg-gray-100 border-b border-gray-300 sm:text-xl bg-opactiy-75 top-12">
            <i class="far fa-comments"></i> Conversations
        </div>

        <div wire:loading class="w-full">
            <x-loader_2 />
        </div>

        @forelse($this->current_conversations as $conversation)
        @php
        $last_message = $conversation->messages->last();
        $unread_count = $conversation->getUnreadFor($profile);
        @endphp
        @if($conversation instanceof \App\Models\DirectConversation)
        @php $partner = $conversation->pair->firstWhere('id', '!==', $profile->id); @endphp
        <div @click="@this.call('switchActiveConv', '{{ $conversation->id }}'); Livewire.emit('hide', true); window.modifyUrl.modify('?activeConversation={{ $conversation->secret_key }}')"
            class="flex items-center px-3 py-2 bg-gray-100 cursor-pointer select-none">
            <div style="background-image: url('{{ $partner->profile_photo_url }}'); background-size: cover; background-position: center center;"
                class="flex-shrink-0 w-12 h-12 mr-3 border-t-2 border-b-2 border-blue-700 rounded-full">
            </div>

            <div class="grid flex-1 flex-shrink-0 grid-cols-1">
                <div class="flex @if($unread_count > 0) items-center @else items-start @endif justify-between">
                    <div class="flex-1 flex-shrink-0 font-semibold text-blue-700 truncate">
                        {{ $partner->full_tag() }}
                        <div class="font-medium text-gray-900 truncate">
                            @if($last_message->sender_id === $profile->id)
                            <span class="text-sm text-blue-700">
                                <x-connect.message.message-status-display :status="$last_message->status" />
                            </span>
                            @endif
                            {{ $last_message->content }}
                        </div>
                    </div>

                    <div class="flex-shrink-0 font-medium text-gray-800">
                        <div class="text-center">
                            {{ $conversation->updated_at->diffForHumans(null, true, true) }}
                        </div>
                        @if($unread_count > 0)
                        <span class="text-xs font-extrabold text-red-600">{{ $unread_count  }} unread</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @continue
        @endif
        @empty
        <div class="flex items-center justify-center p-3 text-blue-700">
            <i style="font-size: 6rem;" class="far fa-comments"></i>
        </div>
        @endforelse
    </div>
    @endif
</div>