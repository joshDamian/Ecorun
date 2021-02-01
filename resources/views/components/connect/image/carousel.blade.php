@props(['gallery'])
<div wire:ignore class="bg-gray-100" x-data x-init="() => {
        window.UiHelpers.buildCarousel( $refs.gallery, {
            lazyLoad: 2,
            imagesLoaded: true,
        });
    }">
    <div x-ref="gallery" class="feed-carousel">
        @foreach($gallery as $key => $image)
        <div class="flex items-center bg-black carousel-post-feed">
            <img class="carousel-cell-image" data-flickity-lazyload="/storage/{{ $image->image_url }}"
                data-flickity-lazyload-src="/storage/{{ $image->image_url }}" alt="post image" />
        </div>
        @endforeach
    </div>
</div>
