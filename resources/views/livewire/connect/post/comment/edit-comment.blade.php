<div>
    <div class="text-right mb-2">
        <x-jet-secondary-button wire:click="confirmDeleteComment">
            <i class="fas text-lg fa-trash text-red-600"></i>
        </x-jet-secondary-button>
    </div>
    <div>
        @error('last_content')
        <div class="bg-gray-100 font-semibold rounded-md border border-red-700 text-center text-red-700 px-3 py-2 mb-2">
            cannot empty comment content... consider deleting the comment.
        </div>
        @enderror
    </div>
    <x-jet-action-message on="saved">
        <div class="bg-gray-100 rounded-md border border-green-600 text-lg font-bold text-center text-green-600 px-3 py-2 mb-2">
            saved
        </div>
    </x-jet-action-message>
    <x-connect.content.create-new-content :photos="$photos" :profilePhotoUrl="$profile->profile_photo_url" type="edit comment" />

    <div>
        <x-jet-confirmation-modal wire:model="confirm">
            <x-slot name="title">
                <div class="text-left">
                    {{ __('Delete Comment') }}
                </div>
            </x-slot>

            <x-slot name="content">
                <div class="text-left">
                    Deleting a comment removes it entirely from our database. Consider editing it.
                </div>
            </x-slot>

            <x-slot name="footer">
                <div>
                    <x-jet-secondary-button wire:click="$toggle('confirm')" class="mr-4">
                        {{ __('Edit') }}
                    </x-jet-secondary-button>
                    <x-jet-danger-button wire:click="deleteComment">
                        {{ __('Delete') }}
                    </x-jet-danger-button>
                </div>
            </x-slot>
        </x-jet-confirmation-modal>
    </div>
</div>