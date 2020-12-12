<div>
    <div class="p-3 sm:p-0 @if($view === 'landing-page') sm:px-5 sm:py-3 @else sm:py-1 @endif @if($ready) border-b @endif border-gray-200">
        <div class="flex @if(!$ready) items-center @else items-start @endif">
            <div style="background-image: url('{{ $profile->profile_photo_url }}'); background-size: cover; background-position: center center;" class="mr-3 border-t-2 border-b-2 border-blue-700 rounded-full w-14 h-14">
            </div>
            <div x-data="{ ready: '{{ $ready }}' }" class="flex-1">
                <div x-show="ready === '1'">
                    <x-connect.content.create-new-content :photos="$photos" type="post" />
                </div>
                <div x-show="ready === ''">
                    <input @focus="ready === '1'" wire:focus="ready" placeholder="say something" class="w-full px-3 py-2 bg-white rounded-full form-input">
                </div>
            </div>
        </div>
    </div>
</div>