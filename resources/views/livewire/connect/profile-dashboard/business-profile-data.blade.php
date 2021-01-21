<div x-data
    x-init="() => { setTimeout(() => { window.modifyUrl.modify('/{{ $profile->full_tag() }}/{{ $action_route }}')}, 1000); }">
    <div class="fixed bottom-0 w-full bg-gray-200 md:sticky md:top-12">
        <ul class="flex overflow-x-auto">
            @foreach($views as $key => $view)
            <li onclick=" window.modifyUrl.modify('{{ $key }}') " wire:click="switchView('{{ $key }}')" class="text-center @if($view === $active_view) text-blue-800 bg-white @else text-gray-800 @endif
                hover:bg-white md:flex-1 flex-shrink-0 hover:text-blue-800 hover:border-transparent md:cursor-pointer
                text-lg py-2 select-none px-3">
                <i class="{{ $view['icon'] }}"></i>&nbsp; {{ ucwords($key) }}
            </li>
            @endforeach
        </ul>
    </div>

    <div wire:loading class="w-full">
        <x-loader_2 />
    </div>

    <div wire:loading.remove class="mt-2 pb-11 md:pb-0 md:mt-0 md:my-3">
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
        <x-connect.profile.display-profile-gallery :profile="$profile" />
        @break

        @case('about')
        <x-connect.profile.display-about-profile :profile="$profile" />
        @break
        @default
        @break
        @endswitch
    </div>
</div>