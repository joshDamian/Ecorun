<div>
    <div class="float-right sm:pr-0 pr-4">
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
