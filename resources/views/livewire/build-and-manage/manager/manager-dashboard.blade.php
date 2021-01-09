<div>
    <div>
        @can('reference-businesses')
        @php $user = Auth::user(); @endphp
        <div wire:key="manager_dashboard" x-data="{ show_create: null, show_list: null }"
            x-init="() => { show_list = true; Livewire.on('newBusiness', () => { show_create = false; show_list = true; }) }"
            class="py-6 md:py-2 md:pb-4">
            <!-- switcher -->
            <div class="flex mx-3 mb-6 sm:mx-4">
                <div class="mr-4">
                    <span :class="show_list ? 'bg-blue-700 text-white' : 'bg-white'"
                        class="px-2 py-3 rounded-md shadow-md select-none md:cursor-pointer"
                        @click=" show_create = false; show_list = true; ">
                        <span>
                            @if($user->loadMissing('isManager.businesses')->isManager->businesses->count() > 1)
                            {{ __('My Businesses') }}
                            @else
                            {{ __('My Business') }}
                            @endif
                        </span>
                    </span>
                </div>

                <div>
                    <span @click=" show_list = false; show_create = true; "
                        :class="show_create ? 'bg-blue-700 text-white' : 'bg-white'"
                        class="px-2 py-3 rounded-md shadow-md select-none md:cursor-pointer">
                        {{ __('Create a New Business') }}
                    </span>
                </div>
            </div>
            <div class="mb-4">
                <div x-show="show_list">
                    <div class="px-3 pt-2 sm:px-4">
                        @livewire('build-and-manage.manager.manager-business-list', ['user' => $user])
                    </div>
                </div>
            </div>

            <div x-show="show_create">
                <div class="pt-2 sm:px-4">
                    @livewire('build-and-manage.business.create-new-business', ['user' => $user], key(time()))
                </div>
            </div>
        </div>
        @endcan
    </div>

    <div>
        @cannot('reference-businesses')
        <div>
            @livewire('build-and-manage.manager.become-a-manager')
        </div>
        @endcannot
    </div>
</div>
