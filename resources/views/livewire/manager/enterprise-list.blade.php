<div>
    <div class="
        @if($enterprises->count() < 2)
        flex justify-center
        @else
        grid grid-cols-2 sm:grid-cols-3 gap-4
        @endif
        ">
        @forelse ($enterprises as $enterprise)
        <div wire:click="displayDashboard('{{ $enterprise->id }}')"
            class="cursor-pointer">
            <x-manager.enterprise-preview :enterprise="$enterprise" />
        </div>
        @empty
        <div>
            <i style="font-size: 10rem;" class="fa fa-exclamation-circle"></i>
            <div class="mt-4">
                you have no enterprises yet
            </div>
        </div>
        @endforelse
    </div>
</div>