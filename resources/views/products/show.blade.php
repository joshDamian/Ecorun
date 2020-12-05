<x-app-layout>
    <div>
        @can('view', $product)
        <div x-data="product_data()" x-init="init_product()" class="">
            <div class="flex flex-col md:flex-row">
                <div class="flex flex-col flex-1 md:flex-row">
                    <!-- Product Image Gallery -->
                    <div class="order-2 sm:order-2 md:order-1">
                        <div class="flex flex-row p-2 md:p-0 md:mr-2 md:flex-col">
                            @foreach($product->gallery as $image)
                            <div style="max-height: 80px; max-width: 80px;" class="@if(!$loop->last) mr-2 md:mb-2 md:mr-0 @endif md:shadow-lg">
                                <img class="max-w-full max-h-full cursor-pointer md:rounded-md" @click=" activeImage = '{{ $image->image_url }}' " :class="('{{ $image->image_url }}' === activeImage) ? 'border-2 border-blue-800' : ''" src="/storage/{{ $image->image_url }}" />
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Active Image -->
                    <div class="flex-1 order-1 md:order-2">
                        <div class="flex items-center justify-center justify-items-center">
                            <img class="w-full h-full md:rounded-md md:shadow-lg" :src="'/storage/' + activeImage" />
                        </div>
                    </div>
                </div>

                <!-- Product Data -->
                <div class="order-3 sm:py-1 md:py-0 sm:pr-1 sm:order-3">
                    <div class="grid grid-cols-1 gap-2 p-2 bg-white sm:p-3 md:mx-2 md:shadow-lg md:rounded-md md:p-3">
                        <div>
                            <!-- Name -->
                            <p class="mt-2 mb-2 text-2xl font-semibold text-blue-800 md:mb-6 md:mt-0">
                                {{ $product->name }}
                            </p>

                            <!-- Rating and link to reviews -->
                            <div class="flex flex-wrap items-baseline justify-between">
                                <div class="mr-3 sm:mr-5">
                                    <i class="text-blue-800 fa fa-star"></i>
                                    <i class="text-blue-800 fa fa-star"></i>
                                    <i class="text-blue-800 fa fa-star"></i>
                                    <i class="text-blue-800 fa fa-star"></i>
                                </div>

                                <div class="mr-3 sm:mr-5">
                                    <a class="font-medium text-blue-800" href="#">
                                        reviews (10)
                                    </a>
                                </div>

                                <div class="text-black">
                                    <i class="fas fa-heart"></i> save to wishlist
                                </div>
                            </div>

                            <div class="flex flex-wrap items-baseline justify-between pt-6">
                                <!-- Price -->
                                <p class="mr-5 text-2xl font-bold text-blue-700">
                                    {!! $product->price() !!}
                                </p>
                                <div>
                                    @livewire('buy.cart.add-to-cart', ['product' => $product], key(md5('add_to_cart'.$product->id)))
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- expansible description  & specifications -->
            <div class="grid grid-cols-1 gap-0 bg-gray-100 md:bg-transparent md:mb-3 md:mt-3">
                <div>
                    <div id="description" @click=" show_description = ! show_description; (show_description) ? window.location = '#description' : true " class="grid grid-cols-2 px-2 py-2 text-lg font-semibold tracking-wide text-gray-700 uppercase border-t-2 border-gray-300 cursor-pointer select-none md:text-xl md:px-1">
                        <span>
                            description
                        </span>
                        <span class="text-right">
                            <i :class="show_description ? 'fa-minus-circle' : 'fa-plus-circle'" class="fas"></i>
                        </span>
                    </div>
                    <div x-show="show_description" class="p-2">
                        <div class="w-full h-full break-words">
                            <p>
                                {{ $product->description }}
                            </p>
                        </div>
                    </div>
                </div>

                <div>
                    <div id="specs" @click=" show_specs = ! show_specs; (show_specs) ? window.location = '#specs' : true " class="grid grid-cols-2 px-2 py-2 text-lg font-semibold tracking-wide text-gray-700 uppercase border-t-2 border-gray-300 cursor-pointer select-none md:text-xl md:px-1">
                        <span>
                            specifications
                        </span>
                        <span class="text-right">
                            <i :class="show_specs ? 'fa-minus-circle' : 'fa-plus-circle'" class="fas"></i>
                        </span>
                    </div>
                    <div x-show="show_specs" class="p-2">
                        <div class="w-full h-full break-words">
                            @if($product->specifications->count() > 0)
                            <div class="grid grid-cols-1 gap-2 md:gap-3 md:grid-cols-3">
                                @foreach($product->specifications as $specification)
                                <div class="bg-gray-100 shadow">
                                    <h3 class="px-3 py-2 text-xl font-semibold text-blue-700 border border-gray-200 rounded-t-sm">
                                        {{ $specification->name }}
                                    </h3>

                                    <table class="table border-collapse rounded-b-sm">
                                        <tr>
                                            @foreach($specification->value as $key => $value)
                                            <td class="px-3 py-2 text-lg font-medium text-center border border-gray-200">{{ $value }}</td>
                                            @endforeach
                                        </tr>
                                    </table>
                                </div>
                                @endforeach
                            </div>
                            @endif
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
