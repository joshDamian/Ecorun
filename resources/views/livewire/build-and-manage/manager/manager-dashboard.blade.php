<div>
    <div>
        @can('reference-businesses')
        @php $user = Auth::user(); @endphp
        <div wire:key="manager_dashboard" x-data="{ show_create: null, show_list: null }"
            x-init="() => { show_list = true; Livewire.on('newBusiness', () => { show_create = false; show_list = true; }) }"
            class="">

            <!-- switcher -->
            <div class="flex mb-2 overflow-x-auto">
                <div @click="show_create = false; show_list = true;"
                    :class="show_list ? 'text-blue-700 bg-white' : 'text-gray-700 bg-gray-200'"
                    class="flex-shrink-0 px-3 py-2 text-lg font-semibold text-center cursor-pointer select-none sm:flex-none">
                    Businesses
                </div>

                <div @click="show_list = false; show_create = true;"
                    :class="show_create ? 'text-blue-700 bg-white' : 'text-gray-700 bg-gray-200'"
                    class="flex-1 flex-shrink-0 px-3 py-2 font-semibold text-center cursor-pointer select-none sm:flex-none">
                    Create New Business
                </div>
            </div>

            <div class="mb-4">
                <div x-show="show_list">
                    <div class="px-3 pt-2 sm:px-4">
                        @livewire('build-and-manage.manager.manager-business-list', ['user' => $user],
                        key(md5("manager_business_list_for_{$user->id}")))
                    </div>
                </div>
            </div>

            <div x-show="show_create">
                <div class="pt-2 sm:px-4">
                    @livewire('build-and-manage.business.create-new-business', ['user' => $user], key(
                    "create_new_business"))
                </div>
            </div>
        </div>
        @endcan
    </div>
</div>
