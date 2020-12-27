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
    <div x-data x-init="() => {
        Livewire.emit('updatedNotifCount');
        Livewire.on('newNotification', (notification) => {
            Livewire.emit('updatedNotifCount');
        })
    }">
    </div>
    @if($display)
    <div class="flex flex-wrap p-2 md:p-0 md:pt-2">
        @foreach($profiles as $key => $profile)
        <div class="mb-2 mr-2">
            <x-connect.profile.switch-profile-for-notif :profile="$profile" :active="$profile->is($activeProfile)" />
        </div>
        @endforeach
    </div>
    <div wire:loading class="w-full">
        <x-loader_2 />
    </div>
    @if($activeProfile)
    <div class="bg-gray-100">
        <x-connect.profile.profile-notifications :profile="$activeProfile" />
    </div>
    @endif
    @endif
</div>
