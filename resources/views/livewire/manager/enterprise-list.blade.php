<div>
    <div class="mb-2 font-bold text-lg">
        @if ($enterprises->count() < 2) {{ __('My Business') }} @else {{ __('My Businesses') }} @endif </div> <div
            class="bg-white 
    @if ($enterprises->count() < 2)
       sm:grid grid-cols-2
    @else
        grid gap-2 sm:gap-4 grid-cols-2 sm:grid-cols-3
    @endif
    ">
            @forelse ($enterprises as $enterprise)
            <a class="block"
                href="{{ route('enterprise.dashboard', ['enterprise' => $enterprise->id, 'active_action' => 'products']) }}">
                <x-enterprise.enterprise-preview :enterprise="$enterprise" />
                <div style="width: 100%;"
                    class="py-2 px-2 bg-gray-900 truncate text-center text-md font-semibold text-white">
                    {{ $enterprise->name }}
                </div>
            </a>
            @empty
            <div>
                <div class="flex justify-center">
                    <i style="font-size: 8rem;" class="fas text-blue-700 fa-battery-empty"></i>
                </div>
                <div class="text-center py-4 px-4 text-blue-700 text-lg font-bold">
                    nothing here, create a business
                </div>
            </div>
            @endforelse
    </div>
</div>
