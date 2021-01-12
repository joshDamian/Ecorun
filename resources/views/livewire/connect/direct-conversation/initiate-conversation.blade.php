<div x-data="{ should_display: false }" x-init="() => { Livewire.on('done', () => { should_display = false; }) }">
    <x-jet-button @click="should_display = true;" class="bg-blue-500">
        <i class="fas text-lg fa-envelope"></i>
    </x-jet-button>

    <div x-show="should_display">
        <x-jet-modal wire:model="should_display">
            <form wire:submit.prevent="initiate">
                <div class="p-3 bg-gray-100 font-extrabold text-lg">
                    <span class="text-gray-700">To</span>
                    <span class="truncate text-blue-700">
                        {{ $joined->full_tag() }}
                    </span>
                </div>
                <div wire:loading wire:target="initiate" class="w-full">
                    <x-loader_2 />
                </div>
                <div class="p-3 flex items-start">
                    <div style="background-image: url('{{ $initiator->profile_photo_url }}'); background-size: cover; background-position: center center;"
                        class="w-11 h-11 mr-3 flex-shrink-0 border-t-2 border-b-2 border-blue-700 rounded-full">
                    </div>
                    <div class="flex-1">
                        <textarea wire:model="message" placeholder="message" class="form-textarea placeholder-blue-700 w-full"></textarea>
                        <x-jet-input-error class="mt-1" for="message"></x-jet-input-error>
                    </div>
                </div>
                <div class="flex items-center justify-end bg-gray-100 p-3">
                    <x-jet-secondary-button onclick="Livewire.emit('done')" class="mr-3">
                        cancel
                    </x-jet-secondary-button>

                    <x-jet-action-message class="mr-3" on="sent">
                        <span class="text-green-600 font-bold">sent</span>
                    </x-jet-action-message>

                    <x-jet-button class="bg-blue-700">
                        send
                    </x-jet-button>
                </div>
            </form>
        </x-jet-modal>
    </div>
</div>