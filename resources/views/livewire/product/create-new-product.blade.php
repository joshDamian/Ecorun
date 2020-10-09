<div>
    @if($product)
    @livewire('product.publish-product', ['product' => $product])
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

                <!-- Product Photos File Input -->
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

            <div class="col-span-12 md:col-span-8 sm:col-span-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Category -->
                    <div>
                        <x-jet-label for="category" value="{{ __('Category Groups') }}" />
                        <div class="relative mt-1">
                            <select wire:model="activeCategory"
                                class="block appearance-none w-full bg-gray-700 border border-gray-700 text-white py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-green-700 focus:border-green-700"
                                id="grid-state">
                                @if(!$activeCategory) <option selected>Select A Category Group</option> @endif
                                @foreach($categories as $category)
                                <option value="{{ $category->title }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-white">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Sub-Category -->
                    @if($activeCategory)
                    <div>
                        <x-jet-label for="sub-category" value="{{ __('Product Category') }}" />
                        <div class="relative mt-1">
                            <select wire:model="product_category"
                                class="block appearance-none w-full bg-gray-700 border border-gray-700 text-white py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-green-700 focus:border-green-700"
                                id="grid-state">
                                @if(!$product_category) <option selected value=''>Select A Category</option> @endif
                                @forelse(App\Models\Category::without('products')->find($activeCategory)->sub_categories
                                as $category)
                                <option value="{{ $category->title }}">{{ $category->title }}</option>
                                @empty
                                <option>no sub-categories</option>
                                @endforelse
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-white">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                        <x-jet-input-error for="product_category" class="mt-2" />
                    </div>
                    @endif
                </div>
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