<div>
    <div class="grid grid-cols-1">
        <div class="bg-gray-100">
            <ul class="flex overflow-x-auto">
                @foreach($views as $key => $view)
                <li onclick=" window.modifyUrl.modify('{{ $key }}') " wire:click="switchView('{{ $key }}')" class="text-center @if($view === $active_view) text-blue-800 bg-white @else text-gray-800 @endif
                    hover:bg-white hover:text-blue-800 hover:border-transparent flex-shrink-0 flex-grow md:cursor-pointer
                    text-lg py-2 select-none px-3">
                    <i class="{{ $view['icon'] }}"></i> &nbsp; {{ ucwords($key) }}
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div wire:loading class="w-full">
        <x-loader_2 />
    </div>

    <div class="mt-2 md:my-3">
        @switch($active_view['title'])
        @case('products')
        @php
        $products = $profile->loadMissing('profileable.products')->profileable->products()->paginate(12);
        @endphp
        <div class="mb-2">
            <x-product.user-product-list :products="$products" />
            <div class="mx-2 md:mx-0">
                <x-paginator :data="$products" />
            </div>
        </div>

        @if($products->isEmpty())
        <div class="p-4 text-blue-700 bg-white">
            <div class="flex items-center justify-center justify-items-center">
                <i style="font-size: 6rem;" class="fas fa-shopping-bag"></i>
            </div>
            <div class="px-3 pt-3 text-center">
                {{ $profile->name }}'s product store is empty <i class="far fa-smile"></i>
            </div>
        </div>
        @endif
        @break

        @case('posts')
        @can('update', $profile)
        <div class="mb-2 ml-0 md:ml-0 md:mb-3">
            @livewire('connect.post.create-new-post', ['profile' => $profile, 'view' => 'timeline'])
        </div>
        @endcan
        <div>
            @livewire('connect.profile.profile-post-list', ['profile' => $profile, 'view' => 'timeline'])
        </div>
        @break

        @case('gallery')
        <div class="grid grid-cols-3 gap-2 sm:grid-cols-4 md:grid-cols-5">
            @php $profile_gallery = $profile->gallery() @endphp
            @forelse($profile_gallery as $key => $picture_post)
            @foreach($picture_post->gallery as $key => $image)
            <a href="{{ route('post.show', ['post' => $picture_post->id]) }}">
                <img class="w-full" src="/storage/{{ $image->image_url }}" />
            </a>
            @endforeach
            @empty
            @php $empty = true; @endphp
            @endforelse
        </div>
        @if($profile_gallery->isEmpty())
        <div class="p-4 text-blue-700 bg-white">
            <div class="flex items-center justify-center justify-items-center">
                <i style="font-size: 6rem;" class="far fa-images"></i>
            </div>
            <div class="px-3 pt-3 text-center">
                {{ $profile->name }}'s gallery is empty <i class="far fa-smile"></i>
            </div>
        </div>
        @endif
        @break

        @case('about')
        <div class="bg-white sm:shadow-sm">
            <p class="p-3 text-lg font-medium text-gray-600 border-b border-gray-300">
                About {{ $profile->name }}
            </p>
            <p class="p-3 text-gray-700 text-md">
                {{ $profile->description }}
            </p>
        </div>
        @break
        @default
        @break
        @endswitch
    </div>
    @if($action_route)
    <script>
        setTimeout(() => {
            window.modifyUrl.modify("/{{ $profile->full_tag() }}/{{ $action_route ?? 'products' }}");
        }, 100);

    </script>
    @endif
</div>
