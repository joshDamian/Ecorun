<div>
    <x-connect.content.create-new-content :photos="$photos" type="post">
        <x-slot name="trigger">
            <div :class="ready ? 'border-b' : ''" class="p-3 sm:p-0 @if($view === 'landing-page') sm:px-5 sm:py-3 @else sm:py-1 @endif border-gray-200">
                <div :class="ready ? 'items-start' : 'items-center'" class="flex">
                    <div style="background-image: url('{{ $profile->profile_photo_url }}'); background-size: cover; background-position: center center;" class="mr-3 border-t-2 border-b-2 border-blue-700 rounded-full w-14 h-14">
                    </div>
                    <div class="flex-1">
                        <input @focus="ready = true" placeholder="say something" class="w-full px-3 py-2 bg-white rounded-full form-input">
                    </div>
                </div>
            </div>
        </x-slot>
    </x-connect.content.create-new-content>
</div>