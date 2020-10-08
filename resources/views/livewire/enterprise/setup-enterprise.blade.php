<div>
    <div class="mb-4">
        <div class="grid mt-4 mb-4 gap-4 sm:grid-cols-12">
            <div class="sm:col-span-4">
                <p class="mb-2 font-bold text-md">
                    What kind of enterprise is {{ $enterprise->name }} ?
                </p>
                <div x-data="{show: null}" x-init="() => { setTimeout(() => { show = true; }, 1000); }">
                    <p x-show="! show" x-on:click="show = true" class="text-green-700 cursor-pointer text-md">
                        Help
                    </p>
                    <div x-show.transition="show"
                        class="mb-3 bg-teal-200 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md"
                        role="alert">
                        <div class="flex">
                            <div class="py-1">
                                <svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold">
                                    Make the right choice
                                </p>
                                <p class="text-sm">
                                    <p>
                                        An ecorun enterprise can either be a Service provider or an Online store.
                                    </p>
                                    <p>
                                        Your selection determines how your enterprise is categorized.
                                    </p>
                                </p>
                                <p class="mt-2 text-right cursor-pointer text-red-700" x-on:click="show = false">
                                    Dismiss
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sm:col-span-8">
                <div class="relative">
                    <select wire:model="type"
                        class="block appearance-none w-full bg-gray-900 border border-gray-900 text-white py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-green-900 focus:border-green-900"
                        id="grid-state">
                        <option>Select an option</option>
                        <option value="store">An Online Store</option>
                        <option value="service">A Service Provider</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-white">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        @switch($type)
        @case("service")
        @livewire('service.create-new-service', ['enterprise' => $enterprise])
        @break
        @case("store")
        @livewire('store.create-new-store', ['enterprise' => $enterprise])
        @break
        @default

        @break
        @endswitch

    </div>
    <div>
        @livewire('enterprise.edit-enterprise', ['enterprise' => $enterprise], key($enterprise->id))
    </div>
</div>
