@push('styles')
<style>
    .g-icon {
        font-size: 50px;
    }
</style>
@endpush
<div>
    <div class="sticky mb-2 overflow-y-auto bg-gray-200 border-b border-gray-300 top-11">
        <h3 class="sticky left-0 flex-shrink-0 p-4 font-bold text-blue-700 truncate text-md md:text-lg">
            <a class="underline" href="{{ route('manager.dashboard') }}">
                <i class="fas fa-store"></i>&nbsp; Businesses
            </a> &nbsp; <i class="fas fa-chevron-right"></i>&nbsp;
            <a class="underline" href="{{ $profile->url->business_url }}">
                {{ $profile->full_tag() }}
            </a>
        </h3>

        <div class="flex items-center flex-1">
            @foreach($actions as $key => $action)
            <div wire:click="switchView('{{$key}}')"
                class="cursor-pointer font-semibold text-md flex-shrink-0 select-none hover:bg-white hover:text-blue-700 px-3 sm:px-5 py-2 @if($active_action['title'] === $action['title']) bg-white text-blue-700 @else text-gray-700 @endif">
                <i class="{{ $action['icon'] }}"></i>&nbsp; {{ ucwords($action['title']) }}
            </div>
            @endforeach
        </div>
    </div>

    <div wire:loading class="w-full mb-2">
        <x-loader_2 />
    </div>

    <div class="py-4 md:pt-2 md:px-4 md:pb-4">
        @switch($active_action['title'])
        @case('sell')
        <div class="">
            @livewire('build-and-manage.business.sell.sell', ['business' => $business, 'sellType' =>
            $action_route_resource])
        </div>
        @break

        @case('warehouse')
        <div>
            @livewire('build-and-manage.business.business-warehouse', ['business' =>
            $business->loadCount('warehouse'), 'active_item' => $action_route_resource],
            key(md5("business_warehouse_{$business->id}")))
        </div>
        @break

        @case('orders')
        <div>
            <div class="flex items-center justify-center p-3 justify-items-center">
                <i style="font-size: 8rem;" class="text-blue-700 fas fa-clipboard-check"></i>
            </div>

            <div class="text-xl font-bold text-center text-blue-700">
                No orders yet.
            </div>
        </div>
        @break

        @case('edit')
        <div>
            @livewire('connect.profile.update-profile', ['profile' => $profile])
        </div>
        @break

        @case('team')
        <div>
            @include('teams.show', ['team' => $this->business->loadMissing('team')->team])
        </div>
        @default
        @break
        @endswitch
    </div>
</div>
