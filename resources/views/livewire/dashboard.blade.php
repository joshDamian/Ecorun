<div>
    <x-app-layout>
        <div class="flex flex-col md:flex-row">

            <div class="bg-gray-900 shadow-lg h-16 fixed bottom-0 mt-12 md:relative md:h-screen z-10 w-full md:w-48">

                <div
                    class="md:mt-12 md:w-48 md:fixed md:left-0 md:top-0 content-center md:content-start text-left justify-between">
                    <ul
                        class="list-reset justify-center sm:overflow-x-hidden overflow-x-scroll flex flex-row md:flex-col py-0 md:py-3 px-1 md:px-2 text-center md:text-left">
                        @foreach ($actions as $key => $action)
                        <li class="@if(!$loop->last) mr-3 @endif flex-grow flex-shrink-0 cursor-pointer">
                            @if($action === $active_action)
                            <a wire:click="switchAction('{{ $key }}')"
                                class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-{{$action['color']}} hover:border-{{$action['color']}}">
                                <i
                                    class="{{ $action['icon'] . ' ' . 'text-' . $action['color'] }} pr-0 md:pr-3"></i><span
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

            <div class="main-content flex-1 bg-gray-100 mt-12 md:mt-2 pb-16 md:pb-5">
                <div class="bg-blue-800 p-2 shadow text-xl text-white">
                    <h3 class="font-bold pl-2">{{ ucfirst($active_action['title']) }}</h3>
                </div>

                <div>
                    @switch($active_action['title'])
                    @case('orders')
                    <div>

                    </div>
                    @break
                    @case('cart')
                    <div>

                    </div>
                    @break
                    @case('manager account')
                    <div>
                        @livewire('manager.dashboard')
                    </div>
                    @break
                    @case('messages')
                    <div>

                    </div>
                    @break
                    @default
                    @break
                    @endswitch
                </div>
            </div>
        </div>
    </x-app-layout>
</div>
@push('scripts')
<script>
    Livewire.on('actionSwitch', () => {
        window.location = '#';
    })

</script>
@endpush