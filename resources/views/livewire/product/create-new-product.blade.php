<div>
    <div style="width: 100%;" wire:loading>
        <x-loader />
    </div>
    @if($product)
    <div class="pb-4 px-4 text-right">
        <x-jet-button @click="window.location = window.location" class="bg-pink-600">
            {{ __('Add Another') }}
        </x-jet-button>
    </div>
    @livewire('product.modify-product-data', ['product' => $product])
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
                <div x-data="{isUploading: false, progress: 0, photosArray: []}" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress" class="col-span-12 md:col-span-8 sm:col-span-6">

                    <!-- Product Photos File Input -->
                    <input type="file" class="hidden" wire:model="photos" multiple x-ref="photos" x-on:change="
                    const files = $refs.photos.files;
                    photosArray = [];
                    for(var i = 0; i < files.length; i++) {
                        photosArray[i] = {'url': URL.createObjectURL(files[i])}
                    }
                    console.log(files.length);
                    " />

                    <x-jet-label for="photos" value="{{ __('Product Photos') }}" />

                    <!-- Product Photos Preview -->
                    <div class="mt-2" x-show.transition="photosArray.length > 0">
                        <div class="grid @if(count($photos) < 2) grid-cols-1 @else grid-cols-2 @endif sm:grid-cols-3 sm:gap-2 gap-2">
                            <template x-for="photo in photosArray">
                                <div x-bind:style="'width: 100%; height: 200px; background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photo.url + '\');'">
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

                <div class="col-span-12 md:col-span-6 sm:col-span-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Category -->
                        <div>
                            <x-jet-label for="category">
                                {{__('Category Groups')}}
                                @if ($enterprise->isService())
                                <span class="text-green-400">
                                    {{__(' (optional) ')}}
                                </span>
                                @endif
                            </x-jet-label>
                            <div class="relative mt-1">
                                <select wire:model="activeCategory" class="block appearance-none w-full bg-blue-900 border border-blue-900 text-white py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-gray-900 focus:border-gray-900" id="grid-state">
                                    @if(!$activeCategory) <option value='' selected>Select A Category Group</option>
                                    @endif
                                    @foreach($categories as $category)
                                    <option value="{{ $category->title }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-white">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Sub-Category -->
                        @if($activeCategory)
                        <div>
                            <x-jet-label for="category">
                                {{__('Product Category')}}
                                @if ($enterprise->isService())
                                <span class="text-green-400">
                                    {{__(' (optional) ')}}
                                </span>
                                @endif
                            </x-jet-label>
                            <div class="relative mt-1">
                                <select wire:model.defer="product_category" class="block appearance-none w-full bg-blue-900 border border-blue-900 text-white py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-gray-900 focus:border-gray-900" id="grid-state">
                                    @if(!$product_category) <option value=''>Select A Category</option> @endif
                                    @forelse(App\Models\Category::without('products')->find($activeCategory)->children
                                    as $category)
                                    <option value="{{ $category->title }}">{{ $category->title }}</option>
                                    @empty
                                    <option>no sub-categories</option>
                                    @endforelse
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-white">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
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
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="name" placeholder="product name" autocomplete="name" />
                    <x-jet-input-error for="name" class="mt-2" />
                </div>

                <!-- Price -->
                <div x-data class="relative col-span-6 sm:col-span-4 md:col-span-3">
                    <x-jet-label for="price" value="{{ __('Product Price') }}" /> (<span x-ref="pricewatch"></span>)
                    <div class="relative">

                        <div class="absolute hidden sm:flex border border-transparent left-0 top-0 h-full w-10">
                            <div class="flex items-center justify-center rounded-tl rounded-bl z-10 bg-gray-100 text-gray-600 text-lg h-full w-full">
                                &#8358;
                            </div>
                        </div>

                        <x-jet-input id="price" type="number" class="relative mt-1 block w-full sm:py-2 sm:pr-2 sm:pl-12" placeholder="product price" wire:model.defer="price" autocomplete="price" />
                    </div>

                    <x-jet-input-error for="price" class="mt-2" />
                </div>

                <!-- Available Stock -->
                <div class="col-span-6 sm:col-span-4 md:col-span-3">
                    <x-jet-label for="category">
                        {{__('Available Stock')}}
                        @if ($enterprise->isService())
                        <span class="text-green-400">
                            {{__(' (optional) ')}}
                        </span>
                        @endif
                    </x-jet-label>
                    <x-jet-input id="available_stock" placeholder="available stock" type="number" class="mt-1 block w-full" wire:model.defer="available_stock" autocomplete="available_stock" />
                    <x-jet-input-error for="available_stock" class="mt-2" />
                </div>

                <!-- Description -->
                <div class="col-span-12 md:col-span-3 sm:col-span-4">
                    <x-jet-label for="description" value="{{ __('Product Description') }}" />
                    <textarea placeholder="product description" rows="3" class="form-input mt-1 block w-full" wire:model.defer="description" autocomplete="description"></textarea>
                    <x-jet-input-error for="description" class="mt-2" />
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
@push('scripts')
<script>
    document.addEventListener('livewire:load', function() {

    })

</script>
@endpush
