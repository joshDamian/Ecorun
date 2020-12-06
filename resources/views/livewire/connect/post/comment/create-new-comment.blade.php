<div>
    <div class="">
        <div class="p-3 sm:px-5 sm:py-3 sm:p-0">
            <div class="flex @if(!$ready) items-center @else items-start @endif">
                <div style="background-image: url('{{ Auth::user()->currentProfile->profile_photo_url }}'); background-size: cover; background-position: center center;" class="w-12 h-12 mr-3 border-t-2 border-b-2 border-blue-700 rounded-full">
                </div>
                <div class="flex-1">
                    @if($ready)
                    <x-connect.content.create-new-content :photos="$photos" type="comment" />
                    @else
                    <input wire:focus="ready" placeholder="add a comment" class="w-full px-3 py-2 bg-white rounded-full form-input">
                    @endif
                </div>
            </div>
            {{-- <x-jet-secondary-button class="text-blue-700" wire:click="ready">
                <i class="fas fa-plus"></i> &nbsp; <span class="lowercase">add a comment</span>
            </x-jet-secondary-button> --}}
        </div>


    </div>
</div>