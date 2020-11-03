<div>
    @can('own-enterprise')
    <div x-data="{ show_create: null, show_list: true }" class="py-4">
        <!-- switcher -->
        <div class="mx-4 flex mb-4">
            <div class="mr-4">
                <span :class="show_list ? 'bg-green-600 text-white' : 'bg-white'" class="rounded-md cursor-pointer shadow-xl py-2 px-2" @click=" show_create = false; show_list = true; ">
                    @if(Auth::user()->isManager->enterprises->count() > 2)
                    {{ __('My Businesses') }}
                    @else
                    {{ __('My Business') }}
                    @endif
                </span>
            </div>

            <div>
                <span @click=" show_list = false; show_create = true; " :class="show_create ? 'bg-green-600 text-white' : 'bg-white'" class="py-2 cursor-pointer rounded-md shadow-xl px-2">
                    {{ __('Create a New Business') }}
                </span>
            </div>
        </div>
        <div>
            <div x-show="show_list">
                <div class="px-4">
                    @livewire('manager.enterprise-list')
                </div>
            </div>
        </div>

        <div x-show="show_create">
            <div class="sm:px-4">
                @livewire('enterprise.create-new-enterprise', key(time()))
            </div>
        </div>
    </div>
    @endcan

    @cannot('own-enterprise')
    <div>
        @livewire('manager.become-a-manager')
    </div>
    @endcannot
</div>
