<div x-data x-init="() => {
    @if($profiles->count() > 1)
    @foreach($profiles as $profile)
    Echo.private('App.Models.Profile.{{$profile->id}}').listen('NewMessageForProfile', () => {
        @this.call('$refresh');
        Livewire.emit('newMessage')
    });
    @endforeach
    @endif
    }">
    @if($profiles->count() > 1)
    <div class="flex border-b border-gray-300">
        @foreach($profiles as $profile)
        @php $unread_count = $profile->unread_messages_count @endphp
        <div wire:click="switchProfile('{{ $profile->id }}')"
            class="p-3 cursor-pointer select-none @if($profile->id === $activeProfile->id) bg-white text-blue-700 @else text-gray-700 @endif">
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

    @if($activeProfile)
    @livewire('connect.conversation.profile-conversations', ['profile' => $activeProfile, 'activeConversation' =>
    request()->input('activeConversation')])
    @endif
</div>
