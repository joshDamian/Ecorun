<div>
    <div class="float-right pr-4 sm:pr-0">
        @if($product->is_published)
        <x-jet-button wire:click="unpublish">
            {{ __('Unpublish') }}
        </x-jet-button>

        @else
        <x-jet-button wire:click="publish">
            {{ __('Publish') }}
        </x-jet-button>
        @endif
    </div>
</div>
