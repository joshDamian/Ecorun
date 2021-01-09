<div>
    <div>
        @can('reference-businesses')
        @php $user = Auth::user(); @endphp
        <div wire:key="manager_dashboard" x-data="{ show_create: null, show_list: null }"
            x-init="() => { show_list = true; Livewire.on('newBusiness', () => { show_create = false; show_list = true; }) }"
            class="bg-gray-200">
            <!-- switcher -->
            <div class="flex overflow-x-auto mb-2">
                <div @click="show_create = false; show_list = true;" :class="show_list ? 'text-blue-700 bg-white' : 'text-gray-700'" class="px-3 cursor-pointer items-center justify-center flex-1 sm:flex-none flex font-semibold flex-shrink-0 py-2 text-lg">
                    Businesses
                </div>

                <div @click="show_list = false; show_create = true;" :class="show_create ? 'text-blue-700 bg-white' : 'text-gray-700'" class="flex-shrink-0 flex-1 sm:flex-none cursor-pointer flex items-center font-semibold justify-center px-3 py-2">
                    Create New Business
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