<div>
    <div class="grid grid-cols-1">
        <div class="bg-gray-100">
            <ul class="flex overflow-x-auto">
                @foreach($views as $key => $view)
                <li onclick=" window.modifyUrl('{{ $key }}') " wire:click="switchView('{{ $key }}')" class="text-center @if($view === $active_view) text-blue-800 bg-white @else text-gray-800 @endif
                    hover:bg-white hover:text-blue-800 hover:border-transparent flex-shrink-0 flex-grow md:cursor-pointer
                    text-lg py-3 select-none px-3">
                    <i class="{{ $view['icon'] }}"></i> &nbsp; {{ ucwords($key) }}
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="mt-2 md:my-3">
        @switch($active_view['title'])
        @case('products')
        <div class="mb-2">
            <x-product.user-product-list :products="$business->products()->where('is_published', true)->latest()->get()" />
        </div>
        @break
        @case('posts')
        @can('update-business', $business->id)
        <div class="mb-2 ml-2 md:ml-0 md:mb-3">
            @livewire('connect.post.create-new-post', ['profile' => $business->profile, 'view' => 'timeline'])
        </div>
        @endcan

        <div>
            @livewire('connect.profile.profile-post-list', ['profile' => $business->profile, 'view' => 'timeline'])
        </div>
        @break

        @case('about')
        <div class="bg-gray-100 sm:shadow-sm">
            <p class="p-2 text-lg font-medium text-gray-600 border-b border-gray-300">
                About {{ $business->profile->name() }}
            </p>
            <p class="p-2 text-gray-700 text-md">
                {{ $business->profile->description }}
            </p>
        </div>
        @break
        @default
        @break
        @endswitch
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('livewire:load', function() {
        window.modifyUrl("/profile/{{ $business->data_slug('name') }}/{{ $business->profile->id }}/visit/{{ array_keys($views, $active_view)[0] }}")
    })

</script>
@endpush