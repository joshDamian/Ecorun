<div>
    <div class="grid sm:gap-6 grid-cols-1 gap-3 sm:grid-cols-12">
        <div class="sm:col-span-4">
            <div class="font-medium text-lg">
                <span>@if ($enterprises->count() < 2) {{ __('My Business') }} @else {{ __('My Businesses') }} @endif </span>
            </div>
        </div>
        <div class="sm:col-span-8">
            <div class="bg-white 
        @if ($enterprises->count() < 2 && $enterprises->count() > 0)
            sm:grid grid-cols-2 bg-gray-400
        @elseif($enterprises->count() < 1)
            flex justify-center
        @else
            grid gap-2 sm:gap-2 grid-cols-2 sm:grid-cols-3
        @endif        
    ">
                @forelse ($enterprises as $enterprise)
                <a class="block shadow" href="{{ route('enterprise.dashboard', ['enterprise' => $enterprise->id, 'active_action' => 'products']) }}">
                    <x-enterprise.enterprise-preview :enterprise="$enterprise" />
                    <div style="width: 100%;" class="py-2 px-2 bg-gray-900 truncate text-center text-md font-semibold text-white">
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
    </div>
</div>
