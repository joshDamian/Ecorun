<div>
    <div class="mb-2 font-bold text-lg">
        {{ __('My Businesses') }}
    </div>
    <div class="grid bg-white gap-4 grid-cols-2 sm:grid-cols-3">
        @forelse ($enterprises as $enterprise)
        <a class="block" href="{{ route('enterprise-dashboard', ['enterprise' => $enterprise->id]) }}">
            <x-enterprise.enterprise-preview :enterprise="$enterprise" />
            <div style="width: 100%;"
                class="py-2 px-2 bg-gray-900 truncate text-center text-md font-semibold text-white">
                {{ $enterprise->name }}
            </div>
        </a>
        @empty

        @endforelse
    </div>
</div>