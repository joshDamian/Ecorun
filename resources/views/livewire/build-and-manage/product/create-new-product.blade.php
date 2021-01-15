<div>
    <div style="width: 100%;" wire:target="photos,create,resetData" wire:loading>
        <x-loader_2 />
    </div>

    @if($product_created)
    <div class="flex justify-end px-4 pb-4 text-right md:px-0">
        <x-jet-secondary-button class="mr-3" wire:click="resetData">
            {{ __('Add Another') }}
        </x-jet-secondary-button>

        <a
            href="{{ route('business.dashboard', ['profile' => $this->business->profile->tag, 'action_route' => 'products']) }}">
            <x-jet-button class="bg-blue-800">
                done
            </x-jet-button>
        </a>
    </div>
    @livewire('build-and-manage.product.product-dashboard', ['product' => $product])

    @else
    <div x-data x-init="() => { window.scrollTo(0, 0); }">
        <x-jet-form-section submit="create">
            <x-slot name="title">
                {{ __('Add Product') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Add a new product to your sales collection') }}
            </x-slot>

            <x-slot name="form">
                <!-- Photos -->
                <div x-data="{isUploading: false, progress: 0, photosArray: []}"
                    x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false"
                    x-on:livewire-upload-error="isUploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress"
                    class="col-span-12 md:col-span-8 sm:col-span-6">

                    <!-- Product Photos File Input -->
                    <input type="file" class="hidden" accept="image/*" wire:model="photos" multiple x-ref="photos"
                        x-on:change="
                    const files = $refs.photos.files;
                    photosArray = [];
                    for(var i = 0; i < files.length; i++) {
                    photosArray[i] = {'url': URL.createObjectURL(files[i])}
                    }
                    console.log(files.length);
                    " />

                    <x-jet-label for="photos" value="{{ __('Product Photos') }}" />

                    <!-- Product Photos Preview -->
                    @if(count($photos) > 0)
                    <div class="mt-2" x-show.transition="photosArray.length > 0">
                        <div
                            class="grid @if(count($photos) < 2) grid-cols-1 @else grid-cols-2 @endif sm:grid-cols-3 sm:gap-2 gap-2">
                            <template x-for="photo in photosArray">
                                <div
                                    x-bind:style="'width: 100%; height: 130px; background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photo.url + '\');'">
                                </div>
                            </template>
                        </div>

                        <div class="mt-2" x-show.transition="isUploading">
                            <progress max="100" x-bind:value="progress"></progress>
                        </div>
                    </div>
                    @endif

                    <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photos.click();">
                        {{ __('Select Product Photos') }}
                    </x-jet-secondary-button>
                    <div class="mt-2">
                        <x-jet-input-error for="photos" />
                        <x-jet-input-error for="photos.*" />
                    </div>
                </div>

                <!-- Name -->
                <div class="col-span-12 md:col-span-6 sm:col-span-4">
                    <x-jet-label for="name" value="{{ __('Product Name') }}" />
                    <x-jet-input id="name" type="text" class="block w-full mt-1" wire:model="product._name"
                        placeholder="product name" autocomplete="name" />
                    <x-jet-input-error for="product._name" class="mt-2" />
                </div>

                <!-- Price -->
                <div x-data class="col-span-6 sm:col-span-4 md:col-span-3">
                    <x-jet-label for="price" value="{{ __('Product Price') }}" />

                    <x-jet-input id="price" step="100" type="number" class="relative block w-full mt-1"
                        placeholder="product price" wire:model.defer="product._price" autocomplete="price" />
                    <x-jet-input-error for="product._price" class="mt-2" />
                </div>

                <!-- Available Stock -->
                <div class="col-span-6 sm:col-span-4 md:col-span-3">
                    <x-jet-label for="available_stock">
                        {{__('Available Stock')}}
                        @if (!$business_is_store)
                        <span class="text-green-400">
                            {{__(' (optional) ')}}
                        </span>
                        @endif
                    </x-jet-label>
                    <x-jet-input id="available_stock" placeholder="available stock" type="number"
                        class="block w-full mt-1" wire:model.defer="product._available stock"
                        autocomplete="available stock" />
                    <x-jet-input-error for="product._available stock" class="mt-2" />
                </div>

                <!-- Description -->
                <div class="col-span-12 md:col-span-6 sm:col-span-4">
                    <x-jet-label for="description" value="{{ __('Product Description') }}" />
                    <textarea placeholder="product description" rows="3" class="block w-full mt-1 form-input"
                        wire:model.defer="product._description" autocomplete="description"></textarea>
                    <x-jet-input-error for="product._description" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="actions">
                <x-jet-action-message class="mr-3" on="added">
                    {{ __('Added.') }}
                </x-jet-action-message>

                <x-jet-button @click=" window.scrollTo(0, 0); " wire:loading.attr="disabled">
                    {{ __('Add') }}
                </x-jet-button>
            </x-slot>
        </x-jet-form-section>
    </div>
    @endif
</div>
