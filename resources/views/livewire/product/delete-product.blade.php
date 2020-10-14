<div>
    <x-jet-dialog-modal wire:model="confirm">
        <x-slot name="title">

        </x-slot>

        <x-slot name="content">

        </x-slot>

        <x-slot name="footer"></x-slot>
    </x-jet-dialog-modal>
    <x-jet-danger-button wire:click="confirmDeleteProduct">
        {{ __('Delete') }}
    </x-jet-danger-button>
</div>
