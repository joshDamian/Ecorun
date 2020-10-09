<div>
    @if($product)
    <x-product.update-product :product="$product" />
    @else
    <x-jet-form-section submit="create">
        <x-slot name="title">
            {{ __('Add Product') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Add a new product to your sales collection') }}
        </x-slot>

        <x-slot name="form">
            <!-- Photos -->
            <div x-data="{isUploading: false, progress: 0, photos: []}" x-on:livewire-upload-start="isUploading = true"
                x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress"
                x-init="@this.on('saved', () => { setTimeout( () => { photosPreview = null; }, 1000); })"
                class="col-span-12 md:col-span-8 sm:col-span-6">

                <!-- Profile Photo File Input -->
                <input type="file" class="hidden" wire:model="photos" multiple x-ref="photos" x-on:change="
                const files = $refs.photos.files;
                photos = [];
                for(var i = 0; i < files.length; i++) {
                photos[i] = {'url': URL.createObjectURL(files[i])}
                }

                console.log(files.length);
                " />

                <x-jet-label for="photos" value="{{ __('Product Photos') }}" />

                <!-- Product Photos Preview -->
                <div class="mt-2" x-show.transition="photos.length > 0">
                    <div class="grid grid-cols-2 sm:grid-cols-3 sm:gap-4 gap-2">
                        <template x-for="photo in photos">
                            <div
                                x-bind:style="'width: 100%; height: 150px; background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photo.url + '\');'">
                            </div>
                        </template>
                    </div>

                    <div class="mt-2" x-show.transition="isUploading">
                        <progress max="100" x-bind:value="progress"></progress>
                    </div>
                </div>

                <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photos.click();">
                    {{ __('Select Product Photos') }}
                </x-jet-secondary-button>
                <x-jet-input-error for="photos.*" class="mt-2" />
            </div>


            <!-- Name -->
            <div class="col-span-12 md:col-span-3 sm:col-span-4">
                <x-jet-label for="name" value="{{ __('Product Name') }}" />
                <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model="name"
                    placeholder="product name" autocomplete="name" />
                <x-jet-input-error for="name" class="mt-2" />
            </div>

            <!-- Price -->
            <div class="col-span-6 sm:col-span-4 md:col-span-3">
                <x-jet-label for="price" value="{{ __('Product Price') }}" />
                <x-jet-input id="price" type="number" class="mt-1 block w-full" placeholder="product price"
                    wire:model="price" autocomplete="price" />
                <x-jet-input-error for="price" class="mt-2" />
            </div>

            <!-- Available Stock -->
            <div class="col-span-6 sm:col-span-4 md:col-span-3">
                <x-jet-label for="available_stock" value="{{ __('Available Stock') }}" />
                <x-jet-input id="available_stock" placeholder="available stock" type="number" class="mt-1 block w-full"
                    wire:model="available_stock" autocomplete="available_stock" />
                <x-jet-input-error for="available_stock" class="mt-2" />
            </div>

            <!-- Description -->
            <div class="col-span-12 md:col-span-3 sm:col-span-4">
                <x-jet-label for="description" value="{{ __('Product Description') }}" />
                <textarea placeholder="product description" rows="5" class="form-input mt-1 block w-full"
                    wire:model="description" autocomplete="description"></textarea>
                <x-jet-input-error for="description" class="mt-2" />
            </div>

        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="added">
                {{ __('Added.') }}
            </x-jet-action-message>

            <x-jet-button wire:loading.attr="disabled">
                {{ __('Add') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>
    @endif
</div>