<div>
    <div class="p-2 sm:p-0 @if($view === 'landing-page') sm:px-5 sm:py-3 @else sm:py-1 @endif @if($ready) border-b @endif border-gray-200">
        <div class="flex @if(!$ready) items-center @else items-start @endif">
            <div style="background-image: url('{{ $profile->profile_image() }}'); background-size: cover; background-position: center center;" class="mr-3 rounded-full border-blue-700 border-t-2 border-b-2 w-14 h-14">
            </div>
            <div class="flex-1">
                @if($ready)
                <x-connect.content.create-new-content :photos="$photos" type="post" />
                @else
                <input wire:focus="ready" placeholder="say something" class="w-full px-3 py-2 bg-white rounded-full form-input">
                @endif
            </div>
        </div>
    </div>
</div>