<div>
    <div style="width: 100%;" wire:loading>
        <x-loader_2 />
    </div>
    @if(!$sellType)
    <h3 class="px-4 mb-2 text-xl font-bold text-gray-600">
        What's for sale?
    </h3>
    <div class="grid grid-cols-1 gap-6 px-6 sm:grid-cols-2 sm:gap-6">
        <div wire:click="select('product/consumable')" class="cursor-pointer">
            <div class="px-4 py-4 bg-gray-100 shadow rounded-t-xl">
                <div class="flex justify-center py-4 overflow-x-auto">
                    <div class="flex justify-center p-5 border-r-2 border-gray-300">
                        <i class="text-blue-700 g-icon fas fa-tshirt"></i>
                    </div>
                    <div class="flex justify-center p-5 border-r-2 border-gray-300">
                        <i class="text-blue-700 fas fa-mobile g-icon"></i>
                    </div>
                    <div class="flex justify-center p-5">
                        <i class="text-blue-700 fas fa-pizza-slice g-icon"></i>
                    </div>
                </div>
            </div>
            <div
                class="px-4 py-3 text-xl font-extrabold text-center text-blue-700 uppercase bg-gray-200 shadow rounded-b-xl">
                consumable / product
            </div>
        </div>

        <div class="cursor-pointer">
            <div class="px-4 py-4 bg-gray-100 rounded-lg shadow">
                <div class="flex justify-center py-4 overflow-x-auto">
                    <div class="flex justify-center p-5 border-r-2 border-gray-300">
                        <i class="text-blue-700 fas fa-laptop-code g-icon"></i>
                    </div>
                    <div class="flex justify-center p-5 border-r-2 border-gray-300">
                        <i class="text-blue-700 fas fa-toolbox g-icon"></i>
                    </div>
                    <div class="flex justify-center p-5">
                        <i class="text-blue-700 fas fa-user-tie g-icon"></i>
                    </div>
                </div>
            </div>
            <div
                class="px-4 py-3 text-xl font-extrabold text-center text-blue-700 uppercase bg-gray-200 shadow rounded-b-xl">
                service / skill
            </div>
        </div>
    </div>
    @else
    <div>
        <div class="mb-2">
            <x-jet-button class="bg-blue-700" wire:click="clear">
                <i class="fas fa-chevron-left"></i>
            </x-jet-button>
        </div>
        @livewire($components[$sellType], ['business' => $business],
        key(time().$business->id))
    </div>
    @endif
</div>
