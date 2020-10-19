<x-app-layout>
    <div class="main-content sm:pt-6 bg-gray-800 pt-14  px-4 mt-12 md:mt-2 pb-4 md:pb-5">
        <div class="sm:grid gap-4 sm:grid-cols-12">
            <div class="sm:col-span-2 bg-white">

            </div>

            <div class="sm:col-span-8">
                <!-- Product gallery -->
                <div>
                    <div class="grid grid-cols-1 @if($product->gallery->count() > 1) sm:grid-cols-2 gap-4 sm:gap-2 @endif"
                        x-data="{ active_image: null }"
                        x-init="() => { active_image = '{{ $product->displayImage() }}'; }">
                        <div class="flex items-center shadow justify-center">
                            <img class="sm:hidden" :src="'/storage/' + active_image" />
                            <img width="500" height="500" class="hidden sm:block" :src="'/storage/' + active_image" />
                        </div>
                        @if($product->gallery->count() > 1)
                        <div class="grid px-2 py-2 sm:py-2 sm:px-2 bg-white gap-2 sm:gap-2 sm:grid-cols-2 grid-cols-4">
                            @foreach ($product->gallery as $image)
                            <div @click=" active_image = '{{ $image->image_url }}'"
                                :class="{ 'border-green-400 border-4': active_image === '{{ $image->image_url }}' }"
                                class="flex justify-center cursor-pointer items-center">
                                <img class="sm:hidden" src="/storage/{{ $image->image_url }}" width="150"
                                height="150" />
                                <img class="hidden sm:block" src="/storage/{{ $image->image_url }}" width="200"
                                height="200" />
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="sm:col-span-2 bg-white">

            </div>
        </div>
    </div>
</x-app-layout>