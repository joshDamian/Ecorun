@props(['gallery'])
<div wire:ignore class="pb-8 bg-gray-100" x-data="{ init: function(){
    window.UiHelpers.buildCarousel( this.$refs.gallery, {
        lazyLoad: 2,
        imagesLoaded: true,
    });
} }" x-init="init()">

    <div x-ref="gallery" class="feed-carousel">
        @foreach($gallery as $key => $image)
        <div class="flex items-center bg-gray-100 carousel-post-feed">
            <img class="carousel-cell-image" data-flickity-lazyload="/storage/{{ $image->image_url }}"
                data-flickity-lazyload-src="/storage/{{ $image->image_url }}" alt="post image" />
        </div>
        @endforeach
    </div>
</div>
