@if(!$profile->profile_photo_path)
<div x-data="{should_show: true}">
    <template x-if="should_show">
        <div class="bg-gray-300 pb-3">
            <div class="px-3 text-xl flex justify-between font-bold bg-white text-blue-700 py-3 sm:px-5">
                <span>
                    <i class="fas fa-clock"></i> Reminder
                </span>

                <span class="flex justify-end">
                    <x-jet-secondary-button x-on:click="should_show = false">
                        <i class="fas fa-times"></i>
                    </x-jet-secondary-button>
                </span>
            </div>

            <div class="bg-gray-100 px-3 py-3 sm:px-5">
                <h3 class="text-gray-800 text-lg font-semibold">
                    @if($profile->isUser())
                    <span>
                        Add a profile photo.
                    </span>
                    @else
                    <span>
                        Add a cover photo for your business.
                    </span>
                    @endif
                </h3>

                <div class="text-gray-600 font-medium">
                    @if($profile->isUser())
                    <span>
                        adding your profile picture helps to express who you are.
                    </span>
                    @else
                    <span>
                        adding a cover photo for your business helps boost your branding.
                    </span>
                    @endif
                </div>
            </div>

            <div class="px-3 flex justify-end items-center py-3 bg-white sm:px-5">
                <x-jet-secondary-button class="border-red-500 text-red-500 mr-3">
                    i no want😑
                </x-jet-secondary-button>

                <a href="{{ $profile->url->edit }}">
                    <x-jet-secondary-button class="border-green-500 text-green-500">
                        I like 😊
                    </x-jet-secondary-button>
                </a>
            </div>
        </div>
    </template>
</div>
@endif