<x-app-layout>
    <div>
        @can('view', $product)
        <div x-data="product_data()" x-init="init_product()" class="">
            <div class="flex flex-col md:flex-row">
                <div class="flex flex-1 flex-col md:flex-row">
                    <!-- Product Image Gallery -->
                    <div class="order-2 sm:order-2 md:order-1">
                        <div class="p-2 md:p-0 md:mr-2 flex flex-row md:flex-col">
                            @foreach($product->gallery as $image)
                            <div style="max-height: 80px; max-width: 80px;" class="@if(!$loop->last) mr-2 md:mb-2 md:mr-0 @endif md:shadow-lg">
                                <img class="cursor-pointer max-h-full rounded-md max-w-full" @click=" activeImage = '{{ $image->image_url }}' " :class="('{{ $image->image_url }}' === activeImage) ? 'border-2 border-blue-800' : ''" src="/storage/{{ $image->image_url }}" />
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Active Image -->
                    <div class="order-1 flex-1 md:order-2">
                        <div class="flex items-center justify-items-center justify-center">
                            <img class="w-full h-full md:rounded-md md:shadow-lg" :src="'/storage/' + activeImage" />
                        </div>
                    </div>
                </div>

                <!-- Product Data -->
                <div class="order-3 sm:py-1 md:py-0 sm:pr-1 sm:order-3">
                    <div class="p-2 sm:p-3 md:mx-2 md:shadow-lg md:rounded-md md:p-3 grid grid-cols-1 gap-2 bg-white">
                        <div>
                            <!-- Name -->
                            <p class="text-blue-800 font-semibold mb-2 md:mb-6 mt-2 md:mt-0 text-2xl">
                                {{ $product->name }}
                            </p>

                            <!-- Rating and link to reviews -->
                            <div class="flex flex-wrap justify-between items-baseline">
                                <div class="mr-3 sm:mr-5">
                                    <i class="fa fa-star text-blue-800"></i>
                                    <i class="fa fa-star text-blue-800"></i>
                                    <i class="fa fa-star text-blue-800"></i>
                                    <i class="fa fa-star text-blue-800"></i>
                                </div>

                                <div class="mr-3 sm:mr-5">
                                    <a class="text-blue-800 font-medium" href="#">
                                        reviews (10)
                                    </a>
                                </div>

                                <div class="text-black">
                                    <i class="fas fa-heart"></i> save to wishlist
                                </div>
                            </div>

                            <div class="flex pt-6 flex-wrap justify-between items-baseline">
                                <!-- Price -->
                                <p class="text-blue-700 font-bold text-2xl mr-5">
                                    {!! $product->price() !!}
                                </p>
                                <div>
                                    @livewire('user-components.cart.add-to-cart', ['product' => $product], key(md5('add_to_cart'.$product->id)))
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- expansible description  & specifications -->
            <div class="grid grid-cols-1 bg-gray-100 md:bg-transparent md:mb-3  md:mt-3 gap-0">
                <div>
                    <div id="description" @click=" show_description = ! show_description; (show_description) ? window.location = '#description' : true " class="cursor-pointer text-lg md:text-xl select-none grid grid-cols-2 font-semibold text-gray-700 uppercase tracking-wide border-t-2 border-gray-300 py-2 px-2 md:px-1">
                        <span>
                            description
                        </span>
                        <span class="text-right">
                            <i :class="show_description ? 'fa-minus-circle' : 'fa-plus-circle'" class="fas"></i>
                        </span>
                    </div>
                    <div x-show="show_description" class="p-2">
                        <div class="w-full break-words h-full">
                            <p>
                                {{ $product->description }}
                            </p>
                        </div>
                    </div>
                </div>

                <div>
                    <div id="specs" @click=" show_specs = ! show_specs; (show_specs) ? window.location = '#specs' : true " class="cursor-pointer text-lg md:text-xl select-none grid grid-cols-2 font-semibold text-gray-700 uppercase tracking-wide border-t-2 border-gray-300 py-2 px-2 md:px-1">
                        <span>
                            specifications
                        </span>
                        <span class="text-right">
                            <i :class="show_specs ? 'fa-minus-circle' : 'fa-plus-circle'" class="fas"></i>
                        </span>
                    </div>
                    <div x-show="show_specs" class="p-2">
                        <div class="w-full break-words h-full">
                            <p>
                                {{ $product->description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan
    </div>

    @push('scripts')
    <script>
        function product_data() {
            return {
                activeImage: null
                , show_description: null
                , show_specs: null
                , init_product() {
                    this.activeImage = '{{ $product->displayImage() }}';
                }
            }
        }

    </script>
    @endpush
</x-app-layout>
