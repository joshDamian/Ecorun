<div>
    @can('manage-enterprise', $enterprise)
    <div class="flex flex-col md:flex-row">
        <div class="bg-gray-900 shadow-lg h-16 fixed bottom-0 mt-12 md:relative md:h-screen z-10 w-full md:w-48">
            <div
                class="md:mt-12 md:w-48 md:fixed md:left-0 md:top-0 content-center md:content-start text-left justify-between">
                <ul
                    class="list-reset justify-center sm:overflow-x-hidden overflow-x-scroll flex flex-row md:flex-col py-0 md:py-3 px-1 md:px-2 text-center md:text-left">
                    @foreach ($actions as $key => $action)
                    @if($key === 'gallery')
                    @if($enterprise->isStore())
                    @continue
                    @endif
                    @endif
                    <li class="@if(!$loop->last) mr-3 @endif flex-grow flex-shrink-0 cursor-pointer">
                        @if($action === $active_action)
                        <a wire:click="switchAction('{{ $key }}')"
                            class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-{{$action['color']}} hover:border-{{$action['color']}}">
                            <i class="{{ $action['icon'] . ' ' . 'text-' . $action['color'] }} pr-0 md:pr-3"></i><span
                                class="pb-1 md:pb-0 text-xs md:text-base text-white md:text-white block md:inline-block">{{ ucfirst($key) }}</span>
                        </a>
                        @else
                        <a wire:click="switchAction('{{ $key }}')"
                            class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-{{$action['color']}}">
                            <i class="{{$action['icon']}} pr-0 md:pr-3"></i><span
                                class="pb-1 md:pb-0 text-xs md:text-base text-gray-600 md:text-gray-400 block md:inline-block">{{ ucfirst($key) }}</span>
                        </a>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="main-content flex-1 bg-gray-100 mt-12 md:mt-2 pb-24 md:pb-5">
            <div class="bg-blue-900 p-2 shadow text-xl text-white">
                <h3 class="font-bold pl-2 truncate">
                    {{ $enterprise->name . ' | ' . ucfirst($active_action['title']) }}
                </h3>
            </div>
            <div style="width: 100%;" wire:loading>
                <x-loader />
            </div>

            <div class="py-4 sm:px-4">
                @switch($active_action['title'])
                @case('add product')
                <div>
                    @livewire('product.create-new-product', ['enterprise' => $enterprise])
                </div>
                @break

                @case('products')
                <div>
                    @livewire('enterprise.product-list', ['enterprise' => $enterprise])
                </div>
                @break

                @case('update business info')
                <div>
                    @livewire('enterprise.update-enterprise', ['enterprise' => $enterprise])
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
                    @include('teams.show', ['team' => $enterprise->team])
                </div>
                @default
                @break
                @endswitch
            </div>
        </div>
    </div>
    @endcan

    @cannot('manage-enterprise', $enterprise)
    <div class="py-4 bg-gray-200 px-4">
        @livewire('enterprise.setup-enterprise', ['enterprise' => $enterprise])
    </div>
    @endcannot
</div>
@push('scripts')
<script>
    Livewire.on('actionSwitch', (action) => {
        var state = {
            id: "100"
        };
        window.history.replaceState(
            state,
            action,
            '&view=' + action
        );
    })

</script>
@endpush