<div>
    <div class="p-2 sm:p-0 @if($view === 'landing-page') flex sm:px-5 sm:py-3 items-center justify-between @else sm:py-1 @endif @if($ready) border-b @endif border-gray-200">
        @if($view === 'landing-page')
        <div class="flex items-center">
            <div style="background-image: url('{{ $profile->profile_image() }}'); background-size: cover; background-position: center center;" class="mr-3 rounded-full w-14 h-14">
            </div>
            <span class="text-lg font-medium">{{ $profile->name() }}</span>
        </div>
        @endif
        <div class="ml-1 md:ml-0">
            <x-jet-secondary-button wire:click="ready" class="text-blue-700">
                <i class="fas fa-plus"></i> &nbsp; New post
            </x-jet-secondary-button>
        </div>
    </div>
    @if($ready)
    <div class="p-2 sm:p-0 @if($view === 'landing-page') sm:px-5 sm:py-3 @else sm:py-1 sm:px-1 @endif">
        <x-connect.content.create-new-content :photos="$photos" type="post" />
    </div>
    @endif
</div>
