<div class="py-4 px-4">
    <div class="flex justify-center flex-wrap">
        @forelse ($enterprises as $enterprise)
        <div wire:click="displayDashboard('{{ $enterprise->id }}')" style="width: 15rem;"
            class="cursor-pointer flex-2 flex-grow-0 flex-shrink-0 mx-3 my-3">
            <x-manager.enterprise-preview :enterprise="$enterprise" />
        </div>
        @empty
        <div class="bg-white">
            <i style="font-size: 10rem;" class="fa fa-exclamation-circle"></i>
            <div class="mt-4">
                you have no enterprises yet
            </div>
        </div>
        @endforelse
    </div>
</div>
