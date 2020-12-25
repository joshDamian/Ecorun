<div>
    @can('manage-business', $this->business)
    @php $auth_user = Auth::user() @endphp
    <div class="sticky px-3 py-2 mb-2 overflow-y-auto bg-gray-200 bg-opacity-50 md:py-3 md:pr-3 top-12">
        <h3 class="sticky left-0 flex-shrink-0 mb-2 font-bold text-blue-700 truncate text-md md:text-lg">
            <a class="underline" href="{{ route('manager.dashboard', ['profile' => $auth_user->profile->tag]) }}">
                {{ $auth_user->profile->name }}
            </a> &nbsp;/
            <a class="underline" href="{{ route('business.dashboard', ['profile' => $auth_user->profile->tag, 'tag' => $this->business->profile->tag]) }}">
                {{ $this->business->profile->full_tag() }}
            </a>
        </h3>

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

    <div wire:loading class="w-full">
        <x-loader />
    </div>

    <div class="py-4 md:py-0 md:px-4 md:pb-4">
        @switch($active_action['title'])
        @case('add product')
        <div>
            @livewire('build-and-manage.product.create-new-product', ['businessId' => $this->business->id], key(time().$this->business->id))
        </div>
        @break

        @case('products')
        <div>
            @livewire('build-and-manage.business.business-product-list', ['business' => $this->business, 'active_product' => $action_route_resource])
        </div>
        @break

        @case('orders')
        <div>
            <div class="flex items-center justify-center p-3 justify-items-center">
                <i style="font-size: 8rem;" class="text-blue-700 fas fa-clipboard-check"></i>
            </div>

            <div class="text-xl font-bold text-center text-blue-700">No orders yet.</div>
        </div>
        @break

        @case('edit')
        <div>
            @livewire('connect.profile.update-profile', ['profile' => $this->business->profile])
        </div>
        @break

        @case('gallery')
        <div>

        </div>
        @break

        @case('team')
        <div>
            @include('teams.show', ['team' => $this->business->team])
        </div>
        @default
        @break
        @endswitch
    </div>

    @if($action_route)
    <script>
        setTimeout(() => {
            window.modifyUrl.modify("/{{$auth_user->profile->full_tag() }}/biz/{{ $this->business->profile->full_tag() }}/{{ $action_route }}@if($action_route_resource)/{{ $action_route_resource }}@endif")
        }, 100);

    </script>
    @endif

    @endcan

    @cannot('manage-business', $this->business)
    <div>
        @livewire('build-and-manage.business.setup-business', ['business' => $this->business])
    </div>
    @endcannot
</div>
