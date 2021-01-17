<div x-data="{ hide: false }" x-init="() => { Livewire.on('newMessage', () => { @this.call('$refresh') })
    Livewire.on('hide', (value) => { hide = value; })
}">
    @if($profiles->count() > 1)
    <div x-show="! hide" class="flex overflow-x-auto border-b border-gray-300">
        @foreach($profiles as $profile)
        @php $unread_count = $profile->unread_messages_count @endphp
        <div onclick="window.modifyUrl.modify('/chat')" wire:click="switchProfile('{{ $profile->id }}')"
            class="p-3 cursor-pointer select-none flex-shrink-0 @if($profile->id === $this->activeProfile->id) bg-white text-blue-700 @else text-gray-700 @endif">
            {{ $profile->full_tag() }} @if($unread_count > 0) &nbsp; <span
                class="text-sm text-red-600">{{ $unread_count }}
                unread</span> @endif
        </div>
        @endforeach
    </div>
    @endif

    <div wire:loading wire:target="switchProfile" class="w-full">
        <x-loader_2 />
    </div>

    @if($this->activeProfile)
    @livewire('connect.conversation.profile-conversations', ['profile' => $this->activeProfile, 'activeConversation' =>
    request()->input('activeConversation')])
    @endif
</div>
