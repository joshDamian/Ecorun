<div x-data="initiate_convo_data()" x-init="() => { Livewire.on('close', () => { should_display = false; }) }">
    <x-jet-button @click="open()" class="bg-blue-600">
        <i class="text-lg fas fa-envelope"></i>
    </x-jet-button>

    <div x-show="should_display">
        <x-jet-modal wire:model="should_display">
            @if($display_sent)
            <div class="grid grid-cols-1 gap-2 p-8 text-blue-700 bg-gray-100">
                <div class="text-2xl font-bold text-center">
                    <span class="text-gray-700">you created a conversation with</span> {{ $joined->full_tag() }}
                </div>

                <div class="text-center">
                    <a href="{{ route('chat.index') }}">
                        <x-jet-button class="bg-blue-700">
                            view in my conversations.
                        </x-jet-button>
                    </a>
                </div>
            </div>
            @else
            <form wire:submit.prevent="initiate">
                <div class="p-3 text-lg font-extrabold bg-gray-100 sm:text-xl">
                    <span class="text-gray-700">To</span>
                    <span class="text-blue-700 truncate">
                        {{ $joined->full_tag() }}
                    </span>
                </div>
                <div wire:loading wire:target="initiate" class="w-full">
                    <x-loader_2 />
                </div>
                <div class="flex items-start p-3">
                    <div style="background-image: url('{{ $initiator->profile_photo_url }}'); background-size: cover; background-position: center center;"
                        class="flex-shrink-0 mr-3 border-t-2 border-b-2 border-blue-700 rounded-full w-11 h-11">
                    </div>
                    <div class="flex-1">
                        <textarea wire:model="message" placeholder="message"
                            class="w-full placeholder-blue-700 form-textarea"></textarea>
                        <x-jet-input-error class="mt-1" for="message"></x-jet-input-error>
                    </div>
                </div>
                <div class="flex items-center justify-end p-3 bg-gray-100">
                    <x-jet-secondary-button onclick="Livewire.emit('close')" class="mr-3">
                        cancel
                    </x-jet-secondary-button>

                    <x-jet-action-message class="mr-3" on="sent">
                        <span class="font-bold text-green-600">sent</span>
                    </x-jet-action-message>

                    <x-jet-button class="bg-blue-700">
                        send
                    </x-jet-button>
                </div>
            </form>
            @endif
        </x-jet-modal>
    </div>
</div>
@push('scripts')
<script>
    function initiate_convo_data() {
        return {
            should_display: false,
            open() {
                @this.should_display = true;
                this.should_display = true;
            }
        }
    }
</script>
@endpush
