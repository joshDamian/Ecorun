<div>
    <div style="width: 100%;" wire:target="photos,create,resetData" wire:loading>
        <x-loader_2 />
    </div>
    @if($service_created)
    <div class="flex justify-end px-4 pb-4 text-right md:px-0">
        <x-jet-secondary-button class="mr-3" wire:click="resetData">
            {{ __('Add Another') }}
        </x-jet-secondary-button>

        <a href="{{ $this->business->url->warehouse }}">
            <x-jet-button class="bg-blue-800">
                done
            </x-jet-button>
        </a>
    </div>
    @livewire('build-and-manage.service.service-dashboard', ['service' => $service],
    key(md5("service_dashboard__for_{$service->id}")))

    @else
    <div x-data x-init="() => { window.scrollTo(0, 0); }">
        <x-jet-form-section submit="create">
            <x-slot name="title">
                {{ __('Add Service') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Add a new service to your warehouse') }}
            </x-slot>

            <x-slot name="form">
                <!-- Photos -->
                <div x-data="{isUploading: false, progress: 0}" x-on:livewire-upload-start="isUploading = true"
                    x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress"
                    class="col-span-12 md:col-span-8 sm:col-span-6">

                    <!-- Product Photos File Input -->
                    <input type="file" class="hidden" accept="image/*" wire:model="photos" multiple x-ref="photos" />

                    <x-jet-label for="photos" value="{{ __('Add photos that describe your service') }}" />

                    <!-- Product Photos Preview -->
                    @if(count($photos) > 0)
                    <div class="mt-2">
                        <x-connect.image.multiple-selector :photos="$photos" />
                        <div class="mt-2" x-show.transition="isUploading">
                            <progress max="100" x-bind:value="progress"></progress>
                        </div>
                    </div>
                    @else
                    <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photos.click();">
                        {{ __('Select Service Photos') }}
                    </x-jet-secondary-button>
                    @endif
                    <div class="mt-2">
                        <x-jet-input-error for="photos" />
                    </div>
                </div>

                <!-- Name -->
                <div class="col-span-12 md:col-span-6 sm:col-span-4">
                    <x-jet-label for="name" value="{{ __('What service are you offering?') }}" />
                    <x-jet-input id="name" name="name" type="text" class="block w-full mt-1" wire:model="service.name"
                        placeholder="service name" autocomplete="name" />
                    <x-jet-input-error for="service.name" class="mt-2" />
                </div>

                <!-- Price -->
                <div x-data="{ pricing_options: { fixed: true, quotation: false } }"
                    class="col-span-6 sm:col-span-4 md:col-span-3">
                    <x-jet-label value="Pricing" />
                    <select wire:model="service.pricing" x-on:change="
                        for(let i in pricing_options) {
                            if(i === event.target.value) {
                                pricing_options[i] = true;
                                continue;
                            }
                            pricing_options[i] = false;
                        }
                        " class="form-select">
                        <option value="fixed">
                            fixed pricing
                        </option>
                        <option value="quotation">
                            based on quotation.
                        </option>
                    </select>
                    <div x-show="pricing_options['fixed']" class="mt-4">
                        <x-jet-label for="price" value="{{ __('How much does your service cost?') }}" />
                        <x-jet-input id="price" type="number" class="relative block w-full mt-1"
                            placeholder="service price" wire:model.defer="service.price" autocomplete="price" />
                        <x-jet-input-error for="service.price" class="mt-2" />
                    </div>
                    <div x-show="pricing_options['quotation']" class="mt-4">
                    </div>
                </div>

                <!-- Description -->
                <div class="col-span-12 md:col-span-6 sm:col-span-4">
                    <x-jet-label for="description" value="{{ __('Add a short description about your service') }}" />
                    <textarea placeholder="service description" rows="3" class="block w-full mt-1 form-input"
                        wire:model.defer="service.description" autocomplete="description"></textarea>
                    <x-jet-input-error for="service.description" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="actions">
                <x-jet-action-message class="mr-3" on="added">
                    {{ __('Added.') }}
                </x-jet-action-message>

                <x-jet-button x-on:click=" window.scrollTo(0, 0); " wire:loading.attr="disabled">
                    {{ __('Add') }}
                </x-jet-button>
            </x-slot>
        </x-jet-form-section>
    </div>
    @endif
</div>
