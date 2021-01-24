@once
@push('styles')
<style>
    .line-clamp {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
@endonce
<div wire:init="loadNotifications">
    <div class="sticky top-0 p-2 text-left text-white bg-blue-800 md:hidden">
        <div class="flex items-center justify-between">
            <div class="flex-1 text-lg font-bold text-center">
                Notifications
            </div>
            <i @click=" open_notifications = false;"
                class="ml-3 text-2xl cursor-pointer active:text-blue-500 hover:text-blue-500 fas fa-times"></i>
        </div>
    </div>

    <div x-data x-init="() => {
        @foreach($profiles as $profile)
        @continue($profile->id === $this->activeProfile->id)
        Echo.private('App.Models.Profile.{{$profile->id}}').listen('NewMessageForProfile', () => {
            Livewire.emit('newMessage')
        }).notification((notification) => {
            Livewire.emit('newNotification', notification);
        });
        @endforeach
    }">
    </div>

    @if($profiles->count() > 1)
    <div class="sticky flex flex-wrap items-center bg-gray-200 bg-opacity-75 border-b border-gray-300 top-12 md:top-0">
        @foreach($profiles as $key => $profile)
        <div class="">
            <x-connect.profile.switch-profile-for-notif :profile="$profile" :unreadCount="$this->unreadCount($profile)"
                :active="$profile->id === $this->activeProfile->id" />
        </div>
        @endforeach
    </div>
    @endif

    <div wire:loading wire:target="mount, switchProfile, showNotifications" class="w-full">
        <x-loader_2 />
    </div>

    @if($display)
    @if($this->activeProfile)
    <div class="bg-gray-100">
        @livewire('general.user.notification-sorter', ['profile' => $this->activeProfile],
        key(md5("notification_sorter_for_{$activeProfile->id}")))
    </div>
    @endif
    @endif
</div>
