<div>
    <form wire:submit.prevent="sendMessage">
        <textarea wire:model="message" class="w-full form-textarea"></textarea>
        <x-jet-input-error for="message" class="mt-2" />
        <div class="mt-2 text-right">
            <x-jet-button class="bg-blue-700">
                send
            </x-jet-button>
        </div>
    </form>
</div>
