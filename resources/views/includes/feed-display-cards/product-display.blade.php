<div>
    @php
    $product = $model;
    $profile = $product->loadMissing('business.profile')->business->profile;
    $profile_visit_url = $profile->url->visit;
    @endphp
    <div class="flex justify-between px-3 py-3 bg-gray-100 border-b border-gray-200 sm:px-5 sm:py-3 sm:p-0">
        <div class="flex items-center flex-1">
            <a class="mr-3" href="{{ $profile_visit_url }}">
                <div style="background-image: url('{{ $profile->profile_photo_url }}'); background-size: cover; background-position: center center;"
                    class="w-12 h-12 border-t-2 border-b-2 border-blue-700 rounded-full">
                </div>
            </a>

            <div>
                <a href="{{ $profile_visit_url }}">
                    <span class="font-medium text-blue-700 text-md">{{ $profile->name }}</span>
                </a>

                <div class="flex items-center">
                    <a class="flex-1 mr-2 truncate" href="{{ $profile_visit_url }}">
                        <span class="text-sm font-normal text-blue-600 truncate">{{ $profile->full_tag() }}</span>
                    </a>

                    <div class="text-sm font-normal text-gray-500">
                        {{ $product->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div
        class="flex flex-wrap justify-between px-3 py-3 text-xl font-bold bg-gray-100 border-b border-gray-200 sm:px-5 sm:py-3 sm:p-0">
        <div class="mr-3 text-blue-800">
            {{ $product->name }}
        </div>
        <div class="text-blue-600">
            {!! $product->price() !!}
        </div>
    </div>

    <div class="flex items-center justify-center p-3 bg-gray-100 border-b border-gray-200 justify-items-center">
        <img class="h-64" src="/storage/{{ $product->gallery->first()->image_url }}" />
    </div>
    <div class="flex items-center justify-end px-3 py-3 text-right bg-gray-100 sm:px-5 sm:py-3 sm:p-0">
        <div class="mr-3">
            @livewire('buy.cart.add-to-cart', ['product' => $product,
            key([microtime()."add_to_cart_{$product->id}".mt_rand(1, 100000)])])
        </div>

        <a href="{{ $product->url->show }}">
            <x-jet-button class="bg-blue-700">
                shop
            </x-jet-button>
        </a>
    </div>
</div>