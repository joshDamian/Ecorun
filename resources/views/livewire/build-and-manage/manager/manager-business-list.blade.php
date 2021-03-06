<div>
    <div class="sm:grid grid-cols-1 gap-2 sm:gap-6 sm:grid-cols-12">
        <div class="sm:col-span-4">
        </div>
        <div class="sm:col-span-8">
            <div class="
                @if ($businesses_count < 2 && $businesses_count > 0)
                sm:grid grid-cols-2
                @elseif($businesses_count < 1)
                flex justify-center bg-white md:shadow-md md:rounded-lg
                @else
                grid gap-2 sm:gap-3 grid-cols-2 sm:grid-cols-2
                @endif
                ">
                @forelse ($businesses as $business)
                <a class="block" href="{{ $business->profile->url->business_url }}">
                    <x-build-and-manage.business.business-preview :business="$business" />
                    <div style="width: 100%;"
                        class="px-2 py-2 font-semibold text-center text-white truncate bg-blue-800 text-md">
                        {{ $business->name() }}
                    </div>
                </a>
                @empty
                <div>
                    <div class="flex items-center justify-center pt-7">
                        <i style="font-size: 6rem;" class="text-blue-700 fas fa-store"></i>
                    </div>
                    <div class="px-4 py-4 text-lg font-bold text-center text-blue-700">
                        nothing here, create a business
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>