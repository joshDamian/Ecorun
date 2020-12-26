<div>
    <div style="width: 100%;" wire:loading>
        <x-loader_2 />
    </div>
    @if($product)
    <div class="flex justify-end px-4 pb-4 text-right md:px-0">
        <a class="mr-3" href="{{ route('business.dashboard', ['tag' => $this->business->profile->tag, 'profile' => Auth::user()->profile->tag, 'action_route' => 'products']) }}">
            <x-jet-button class="bg-blue-800">
                done
            </x-jet-button>
        </a>

        <x-jet-button @click=" window.location = window.location " class="bg-blue-600">
            {{ __('Add Another') }}
        </x-jet-button>
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
                <div x-data="{isUploading: false, progress: 0, photosArray: []}" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress" class="col-span-12 md:col-span-8 sm:col-span-6">

                    <!-- Product Photos File Input -->
                    <input type="file" class="hidden" accept="image/*" wire:model="photos" multiple x-ref="photos" x-on:change="
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
                                <div x-bind:style="'width: 100%; height: 130px; background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photo.url + '\');'">
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
                    <div class="mt-2">
                        <x-jet-input-error for="photos" />
                        <x-jet-input-error for="photos.*" />
                    </div>
                </div>

                <div class="static col-span-12 md:col-span-6 sm:col-span-4">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <!-- Category -->
                        <div>
                            <x-jet-label for="category">
                                {{__('Category Groups')}}
                                @if ($this->business->isService())
                                <span class="text-green-400">
                                    {{__(' (optional) ')}}
                                </span>
                                @endif
                            </x-jet-label>
                            <div class="relative mt-1">
                                <select wire:model="activeCategory" class="block w-full px-4 py-3 pr-8 leading-tight text-white bg-blue-900 border border-blue-900 rounded appearance-none focus:outline-none focus:bg-gray-900 focus:border-gray-900" id="grid-state">
                                    @if(!$activeCategory) <option value='' selected>Select A Category Group</option>
                                    @endif
                                    @foreach($categories as $category)
                                    <option value="{{ $category->title }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 text-white pointer-events-none">
                                    <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
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
                                @if ($this->business->isService())
                                <span class="text-green-400">
                                    {{__(' (optional) ')}}
                                </span>
                                @endif
                            </x-jet-label>
                            <div class="relative mt-1">
                                <select wire:model.defer="product_category" class="block w-full px-4 py-3 pr-8 leading-tight text-white bg-blue-900 border border-blue-900 rounded appearance-none focus:outline-none focus:bg-gray-900 focus:border-gray-900" id="grid-state">
                                    @if(!$product_category) <option value=''>Select A Category</option> @endif
                                    @forelse(App\Models\Category::without('products')->find($activeCategory)->children
                                    as $category)
                                    <option value="{{ $category->title }}">{{ $category->title }}</option>
                                    @empty
                                    <option>no sub-categories</option>
                                    @endforelse
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 text-white pointer-events-none">
                                    <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
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
                    <x-jet-input id="name" type="text" class="block w-full mt-1" wire:model.defer="name" placeholder="product name" autocomplete="name" />
                    <x-jet-input-error for="name" class="mt-2" />
                </div>

                <!-- Price -->
                <div x-data class="static col-span-6 sm:col-span-4 md:col-span-3">
                    <x-jet-label for="price" value="{{ __('Product Price') }}" /> (<span x-ref="pricewatch"></span>)
                    <div class="relative">

                        <div class="absolute top-0 left-0 hidden w-10 h-full border border-transparent sm:flex">
                            <div class="z-10 flex items-center justify-center w-full h-full text-lg text-gray-600 bg-gray-100 rounded-tl rounded-bl">
                                &#8358;
                            </div>
                        </div>

                        <x-jet-input id="price" step="100" type="number" class="relative block w-full mt-1 sm:py-2 sm:pr-2 sm:pl-12" placeholder="product price" wire:model.defer="price" autocomplete="price" />
                    </div>

                    <x-jet-input-error for="price" class="mt-2" />
                </div>

                <!-- Available Stock -->
                <div class="col-span-6 sm:col-span-4 md:col-span-3">
                    <x-jet-label for="category">
                        {{__('Available Stock')}}
                        @if ($this->business->isService())
                        <span class="text-green-400">
                            {{__(' (optional) ')}}
                        </span>
                        @endif
                    </x-jet-label>
                    <x-jet-input id="available_stock" placeholder="available stock" type="number" class="block w-full mt-1" wire:model.defer="available_stock" autocomplete="available_stock" />
                    <x-jet-input-error for="available_stock" class="mt-2" />
                </div>

                <!-- Description -->
                <div class="col-span-12 md:col-span-3 sm:col-span-4">
                    <x-jet-label for="description" value="{{ __('Product Description') }}" />
                    <textarea placeholder="product description" rows="3" class="block w-full mt-1 form-input" wire:model.defer="description" autocomplete="description"></textarea>
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
    document.addEventListener('livewire:load', function() {})

</script>
@endpush
