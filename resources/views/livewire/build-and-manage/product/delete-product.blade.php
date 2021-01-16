<div>
    <x-jet-confirmation-modal wire:model="confirm">
        <x-slot name="title">
            <div class="text-left">
                {{ __('Delete Product') }}
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="text-left">
                Deleting a product removes it entirely from our database, if you want to hide the product, unpublish it
                instead.
            </div>
        </x-slot>

        <x-slot name="footer">
            <div>
                <x-jet-secondary-button wire:click="$toggle('confirm')" class="mr-4">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>
                <x-jet-danger-button wire:click="delete">
                    {{ __('Delete Product') }}
                </x-jet-danger-button>
            </div>
        </x-slot>
    </x-jet-confirmation-modal>
    <x-jet-danger-button wire:click="confirmDeleteProduct">
        {{ __('Delete') }}
    </x-jet-danger-button>
</div>
