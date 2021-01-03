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
            <i @click=" open_notifications = false; Livewire.emit('hideNotifications')" class="ml-3 text-2xl fas fa-times"></i>
        </div>
    </div>

    <div x-data x-init="() => {
        @foreach($profiles as $key => $profile)
        Echo.private('App.Models.Profile.{{$profile->id}}').notification((notification) => {
        Livewire.emit('newNotification', notification);
        });
        @endforeach
        }">
    </div>

    <div class="sticky top-0 flex flex-wrap p-2 bg-gray-200 bg-opacity-50 md:p-2">
        @foreach($profiles as $key => $profile)
        <div class="mb-2 mr-2">
            <x-connect.profile.switch-profile-for-notif :profile="$profile" :active="$profile->is($activeProfile)" />
        </div>
        @endforeach
    </div>

    <div wire:loading wire:target="mount,switchProfile" class="w-full">
        <x-loader_2 />
    </div>

    @if($display)
    @if($activeProfile)
    <div class="bg-gray-100">
        <x-connect.profile.profile-notifications :profile="$activeProfile" />
    </div>
    @endif
    @endif
</div>
