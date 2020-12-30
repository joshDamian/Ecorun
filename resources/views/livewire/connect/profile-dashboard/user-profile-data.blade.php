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
    <div class="mt-2 md:mt-3 md:mb-3">
        @switch($active_view['title'])
        @case('posts')
        @can('update', $profile)
        <div class="mb-2 md:mb-3">
            @livewire('connect.post.create-new-post', ['profile' => $profile, 'view' => 'timeline'])
        </div>
        @endcan

        <div>
            @livewire('connect.profile.profile-post-list', ['profile' => $profile, 'view' => 'timeline'])
        </div>
        @break

        @case('gallery')
        <div class="grid grid-cols-3 gap-2 sm:grid-cols-4 md:grid-cols-5">
            @foreach($profile->gallery() as $key => $picture_post)
            @foreach($picture_post->gallery as $key => $image)
            <a href="{{ route('post.show', ['post' => $picture_post->id]) }}">
                <img class="w-full" src="/storage/{{ $image->image_url }}" />
            </a>
            @endforeach
            @endforeach
        </div>
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
</div>
@once
@push('scripts')

<script>
    document.addEventListener('livewire:load', function() {
        window.modifyUrl.modify("/{{ $profile->full_tag() }}/{{ $action_route }}")
    })

</script>
@endpush
@endonce