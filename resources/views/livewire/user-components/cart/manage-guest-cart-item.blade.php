<div>
    <form wire:submit.prevent="update">
        <div class="p-1">
            <x-jet-label value="quantity" />
            <input style="width: 30%;" class="mt-1 text-center border-2 rounded border-gray-200 px-2 py-1" wire:model="cart_item.quantity" />
            <x-jet-input-error for="cart_item.quantity" />
        </div>
        <div class="flex items-center justify-end mt-4 bg-gray-50 text-right">
            <div class="mr-3">
                <x-jet-secondary-button wire:loading.attr="disabled" style="color: white;" class="border border-red-700 bg-red-700" wire:click="delete">
                    <i class="fa fa-trash"></i>
                </x-jet-secondary-button>
            </div>
            <x-jet-action-message class="mr-3" on="updated">
                {{ __('updated.') }}
            </x-jet-action-message>

            <x-jet-button class="bg-green-700" wire:loading.attr="disabled">
                <i class="fa fa-edit"></i>
            </x-jet-button>
        </div>
    </form>
</div>
