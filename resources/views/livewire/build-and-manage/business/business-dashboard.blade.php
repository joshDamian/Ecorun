<div>
    @can('manage-business', $business)
    <div class="sticky px-3 py-2 mb-2 overflow-y-auto bg-gray-200 bg-opacity-50 md:py-3 md:pr-3 top-12">
        <h3 class="sticky left-0 flex-shrink-0 mb-2 font-bold text-blue-700 truncate text-md md:text-lg">
            <a href="{{ route('dashboard', ['active_action' => 'manager-account']) }}">
                {{ $business->manager->user->profile->name }}
            </a>/
            {{ $business->profile->full_tag() }} </h3>
        <div class="flex items-center flex-1">
            @foreach($actions as $key => $action)
            @if($active_action['title'] === $action['title'])
            <x-jet-secondary-button class="flex items-center flex-shrink-0 mr-3 border-t-2 border-b-2 border-blue-700 rounded-full" wire:click="switchAction('{{ $key }}')">
                <i class="{{ $action['icon'] }}"></i> &nbsp; {{ $action['title'] }}
            </x-jet-secondary-button>
            @else
            <x-jet-secondary-button class="flex items-center flex-shrink-0 mr-3 bg-gray-100 rounded-full" wire:click="switchAction('{{ $key }}')">
                <i class="{{ $action['icon'] }}"></i> &nbsp; {{ $action['title'] }}
            </x-jet-secondary-button>
            @endif
            @endforeach
        </div>
    </div>

    <div class="py-4 md:py-0 md:pb-4">
        @switch($active_action['title'])
        @case('add product')
        <div>
            @livewire('build-and-manage.product.create-new-product', ['businessId' => $business->id], key(time().$business->id))
        </div>
        @break

        @case('products')
        <div>
            @livewire('build-and-manage.business.business-product-list', ['business' => $business, 'active_product' => $action_route_resource])
        </div>
        @break

        @case('orders')
        <div>

        </div>
        @break

        @case('gallery')
        <div>

        </div>
        @break

        @case('management team')
        <div>
            @include('teams.show', ['team' => $business->team])
        </div>
        @default
        @break
        @endswitch
    </div>
    @once
    @push('scripts')
    <script>
        document.addEventListener('livewire:load', function() {

            setTimeout(() => {
                window.modifyUrl("/business/{{ $business->profile->full_tag() }}/{{ $business->id }}/{{ $action_route }}@if($action_route_resource)/{{ $action_route_resource ?? '' }}@endif")
            }, 10);

        })

    </script>
    @endpush
    @endonce

    @endcan

    @cannot('manage-business', $business)
    <div>
        @livewire('build-and-manage.business.setup-business', ['business' => $business])
    </div>
    @endcannot
</div>
