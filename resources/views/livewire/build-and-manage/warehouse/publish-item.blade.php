<div>
    <div class="float-right pr-4 sm:pr-0">
        @if($item->is_published)
        <x-jet-button wire:click="unpublish">
            {{ __('Unpublish') }}
        </x-jet-button>

        @else
        <x-jet-button wire:click="publish">
            {{ __('Publish') }}
        </x-jet-button>
        <x-jet-action-message on="publishingError">
            <x-jet-input-error for="publishing" />
        </x-jet-action-message>
        @endif
    </div>
</div>
