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
<div>
    <div class="sticky top-0 p-2 text-left text-white bg-blue-800 md:hidden">
        <div class="flex items-center justify-between">
            <div class="flex-1 text-lg font-bold text-center">
                Notifications
            </div>
            <i @click=" open_notifications = false; Livewire.emit('hideNotifications')"
                class="ml-3 text-2xl fas fa-times"></i>
        </div>
    </div>

    <div x-data x-init="() => {
        @foreach($profiles as $key => $profile)
        @continue($profile->is($activeProfile))
        Echo.private('App.Models.Profile.{{$profile->id}}').notification((notification) => {
        Livewire.emit('newNotification', notification);
        });
        @endforeach
        }">
    </div>

    @if($profiles->count() > 1)
    <div class="sticky top-0 flex flex-wrap p-2 bg-gray-200 bg-opacity-50">
        @foreach($profiles as $key => $profile)
        <div class="@if(!$loop->last) mb-2 @endif mr-2">
            <x-connect.profile.switch-profile-for-notif :profile="$profile" :unreadCount="$this->unreadCount($profile)"
                :active="$profile->is($activeProfile)" />
        </div>
        @endforeach
    </div>
    @endif

    <div wire:loading wire:target="mount,switchProfile,showNotifications,handle" class="w-full">
        <x-loader_2 />
    </div>

    @if($display)
    @if($activeProfile)
    <div class="bg-gray-100">
        @livewire('connect.profile.profile-notifications-handler', ['profile' =>
        $activeProfile, 'notifications_for_profile' => $this->notifsForProfile($activeProfile)])
    </div>
    @endif
    @endif
</div>
