<div>
    <x-jet-form-section submit="create">
        <x-slot name="title">
            {{ __('Business Creation') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Create an online presence for your business.') }}
        </x-slot>

        <x-slot name="form">

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input placeholder="business name" id="name" type="text" class="block w-full mt-1"
                    wire:model="name" autocomplete="name" />
                <x-jet-input-error for="name" class="mt-2" />
            </div>

            @if($name && !$errors->has('name'))
            <div class="col-span-6 sm:col-span-4">
                <h3 class="p-0 mb-3 font-bold text-blue-800 text-md">
                    What kind of business is {{ $name }} ?
                </h3>

                <div class="relative mb-3">
                    <select wire:model="type"
                        class="block w-full px-4 py-3 pr-8 leading-tight text-white bg-blue-800 border border-blue-800 rounded appearance-none focus:outline-none focus:bg-green-900 focus:border-green-900"
                        id="grid-state">
                        <option value="">Select an option</option>
                        <option value="store">An Online Store</option>
                        <option value="service">A Service Provider</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 text-white pointer-events-none">
                        <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                        </svg>
                    </div>
                </div>
                <x-jet-input-error for="type" class="mt-2" />

                <div x-data="{show: null}" x-init="() => { setTimeout(() => { show = true; }, 500); }">
                    <p x-show="! show" x-on:click="show = true" class="mb-1 text-green-700 cursor-pointer text-md">
                        Help
                    </p>
                    <div x-show.transition="show"
                        class="px-4 py-3 mb-3 text-teal-900 bg-teal-200 border-t-4 border-teal-500 rounded-b shadow-md"
                        role="alert">
                        <div class="flex">
                            <div class="py-1">
                                <svg class="w-6 h-6 mr-4 text-teal-500 fill-current" xmlns="http://www.w3.org/2000/svg"
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
                                        An ecorun business can either be a Service provider or an Online store.
                                    </p>
                                    <p>
                                        Your selection determines how your business is categorized.
                                    </p>
                                </p>
                                <p class="mt-2 text-right text-red-700 md:cursor-pointer" x-on:click="show = false">
                                    Dismiss
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="created">
                {{ __('Created.') }}
            </x-jet-action-message>

            <x-jet-button wire:loading.attr="disabled">
                {{ __('Create') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>
</div>
