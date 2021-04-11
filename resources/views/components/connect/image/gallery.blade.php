@props(['gallery', 'height' => 'h-28', 'view' => 'single', 'curve' => ''])
<div>
    <div x-data="{ activeImage: false, display_limit: 3, gallery: {{ json_encode($gallery) }}, view: '{{ $view }}', curve: ('{{ $curve }}' !== '') ? true : false, makeActive: (image) => {
        return new Promise(function(resolve, reject) {
        if(image !== '') {
        resolve(image);
        } else {
        reject('couldn\'t set active image');
        }
        }) }, }" wire:key="gallery_{{ $gallery->first()->id }}" wire:ignore class="gallery">
        <div class="grid gap-1"
            :class="{ 'grid-cols-1': gallery.length === 1, 'grid-cols-2': gallery.length >= 2, 'grid-cols-2 sm:grid-cols-4': gallery.length >= 3 && (view === 'single')}">
            <template x-for="i in display_limit" :key="i">
                <div>
                    <template x-if="i <= gallery.length">
                        <div :class="{ '{{ $curve }}': curve, 'h-40 md:52': (gallery.length === 2 && (view === 'single')) || gallery.length === 1 }"
                            x-on:click="makeActive(gallery[i - 1].image_url).then(image => { activeImage = image; setTimeout(() => { var object = document.getElementById(image); if(object){ object.scrollIntoView(); } else { console.log(object) }  }, 2000); }).catch(x => console.error(x))"
                            :style="'background-image: url(/storage/' +  gallery[i - 1].image_url +'); background-size: cover; background-position: center center;'"
                            class="w-full {{ $height }} cursor-pointer">
                        </div>
                    </template>
                </div>
            </template>

            <div>
                <template x-if="gallery.length > 3">
                    <div x-on:click="activeImage = gallery[3].image_url"
                        :style="'background-image: url(/storage/' + gallery[3].image_url +'); background-size: cover; background-position: center center;'"
                        class="{{ $height }} cursor-pointer border border-gray-300">
                        <div
                            class="flex {{ $curve }} justify-center font-bold h-full w-full text-white text-2xl items-center bg-black bg-opacity-50">
                            <i class="mr-2 fas fa-plus"></i> <span x-text="gallery.length - 3"></span>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <template x-if="activeImage">
            <div class="fixed inset-0 z-50 flex flex-col w-screen h-screen bg-black md:flex-row">
                <div class="absolute top-0 w-full px-3 py-1 bg-black bg-opacity-25">
                    <i x-on:click="activeImage = false" class="text-2xl text-white cursor-pointer fas fa-times"></i>
                </div>

                <div :class="(gallery.length > 1) ? 'h-4/5 md:mr-2' : 'h-full'"
                    class="flex items-center justify-center flex-1 md:h-full">
                    <img :src="'/storage/' + activeImage" class="max-w-full max-h-full" />
                </div>

                <template x-if="gallery.length > 1">
                    <div
                        class="flex flex-row mx-2 mt-2 overflow-x-auto md:overflow-y-auto md:h-full h-1/6 md:flex-col md:mx-0 md:mt-0">
                        <template x-for="(image, index) in gallery" :key="index">
                            <div :id="image.image_url" x-on:click="activeImage = image.image_url;"
                                :style="'background-image: url(/storage/' + image.image_url +'); background-size: cover; background-position: center center;'"
                                class="flex-shrink-0 h-full cursor-pointer w-28 md:w-28 md:h-28"
                                :class="{ 'mr-2 md:mb-2 md:mr-0': index !== gallery.length - 1, 'border-4 border-white': image.image_url === activeImage }">
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </template>
    </div>
</div>