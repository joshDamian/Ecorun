<div>
    <div>
        @can('own-businesses')
        <div wire:key="manager_dashboard" x-data="{ show_create: null, show_list: null }" x-init="() => { show_list = true }" class="py-4 md:py-2 md:pb-4">
            <!-- switcher -->
            <div class="flex mx-2 mb-4 sm:mx-4">
                <div class="mr-4">
                    <span :class="show_list ? 'bg-green-600 text-white' : 'bg-white'" class="px-2 py-2 rounded-md shadow-md md:cursor-pointer" @click=" show_create = false; show_list = true; ">
                        <span>
                            @if(Auth::user()->isManager->businesses->count() > 2)
                            {{ __('My Businesses') }}
                            @else
                            {{ __('My Business') }}
                            @endif
                        </span>
                    </span>
                </div>

                <div>
                    <span @click=" show_list = false; show_create = true; " :class="show_create ? 'bg-green-600 text-white' : 'bg-white'" class="px-2 py-2 rounded-md shadow-md md:cursor-pointer">
                        {{ __('Create a New Business') }}
                    </span>
                </div>
            </div>
            <div class="mb-4">
                <div x-show="show_list">
                    <div class="px-2 sm:px-4">
                        @livewire('build-and-manage.manager.manager-business-list')
                    </div>
                </div>
            </div>

            <div x-show="show_create">
                <div class="sm:px-4">
                    @livewire('build-and-manage.business.create-new-business', key(time()))
                </div>
            </div>
        </div>
        @endcan
    </div>

    <div>
        @cannot('own-businesses')
        <div>
            @livewire('build-and-manage.manager.become-a-manager')
        </div>
        @endcannot
    </div>
</div>