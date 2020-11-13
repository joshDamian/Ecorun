<div>
    <form wire:submit.prevent="update">
        <div class="p-1">
            <x-jet-label value="quantity" />
            <input style="width: 30%;" class="mt-1 text-center border-2 rounded border-gray-200 px-2 py-1" wire:model="cart_item.quantity" min="1" />
            <x-jet-input-error for=" cart_item.quantity" />
        </div>
        <div class="flex items-center justify-end mt-4 bg-gray-50 text-right">
            <div class="mr-3">
                <x-jet-danger-button wire:click="delete">
                    <i class="fa fa-trash"></i>
                </x-jet-danger-button>
            </div>
            <div>
                <x-jet-button class="bg-green-700" wire:loading.attr="disabled">
                    <i class="fa fa-edit"></i>
                </x-jet-button>
            </div>
        </div>
    </form>
</div>
