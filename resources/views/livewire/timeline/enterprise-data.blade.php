<div>
    <div class="grid grid-cols-1 sm:grid-cols-2">
        <div class="mt-2 mx-2 md:mx-0 md:mt-3">
            <ul class="flex overflow-x-auto">
                @foreach($views as $key => $view)
                <li onclick=" window.modifyUrl('{{ $key }}') " wire:click="switchView('{{ $key }}')" class="text-center @if($view === $active_view) text-blue-800 bg-white @else border text-gray-800 @endif 
                      hover:bg-white hover:text-blue-800 hover:border-transparent flex-shrink-0 flex-grow md:cursor-pointer 
                        @if($loop->first) sm:rounded-l-md @endif @if($loop->last) sm:rounded-r-md @endif text-lg py-2 px-3">
                    <i class="{{ $view['icon'] }}"></i> &nbsp; {{ ucwords($key) }}
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="my-2 md:my-3">
        @switch($active_view['title'])
        @case('products')
        <div>
            <x-product.user-product-list :products="$enterprise->products()->where('is_published', true)->latest()->get()" />
        </div>
        @break
        @case('posts')
        <div class="mb-2 md:mb-3">
            @livewire('posts.create-new-post', ['profile' => $enterprise->profile, 'view' => 'timeline'])
        </div>

        <div>
            @livewire('posts.profile-post-list', ['profile' => $enterprise->profile, 'view' => 'timeline'])
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
        window.modifyUrl("/timeline/{{ $enterprise->data_slug('name') }}/{{ $enterprise->profile->id }}/{{ array_keys($views, $active_view)[0] }}")
    })

</script>
@endpush
