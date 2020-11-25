<div>
    <div class="grid grid-cols-1">
        <div class="bg-gray-100">
            <ul class="flex overflow-x-auto">
                @foreach($views as $key => $view)
                <li onclick=" window.modifyUrl('{{ $key }}') " wire:click="switchView('{{ $key }}')" class="text-center @if($view === $active_view) text-blue-800 bg-white @else text-gray-800 @endif
                    hover:bg-white hover:text-blue-800 hover:border-transparent flex-shrink-0 flex-grow md:cursor-pointer
                    text-lg py-3 px-3">
                    <i class="{{ $view['icon'] }}"></i> &nbsp; {{ ucwords($key) }}
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="mt-2 md:mt-3">
        @switch($active_view['title'])
        @case('posts')
        @can('update', $user->profile)
        <div class="mb-2 ml-2 md:ml-0 md:mb-3">
            @livewire('posts.create-new-post', ['profile' => $user->profile, 'view' => 'timeline'])
        </div>
        @endcan

        <div>
            @livewire('posts.profile-post-list', ['profile' => $user->profile, 'view' => 'timeline'])
        </div>
        @break
        @case('about')
        <div class="bg-gray-100  sm:shadow-sm sm:rounded-md">
            <p class="text-lg border-b p-2 font-medium border-gray-300 text-gray-600">
                About {{ $user->profile->name() }}
            </p>
            <p class="text-gray-700 p-2 text-md">
                {{ $user->profile->description }}
            </p>
        </div>
        @break
        @default
        @break
        @endswitch
    </div>
</div>
@push('scripts')
@if(request()->routeIs('timeline.show'))
<script>
    document.addEventListener('livewire:load', function() {
        window.modifyUrl("/timeline/{{ $user->data_slug('name') }}/{{ $user->profile->id }}/{{ array_keys($views, $active_view)[0] }}")
    })

</script>
@else
<script>
    document.addEventListener('livewire:load', function() {
        window.modifyUrl("/timeline.me/{{ array_keys($views, $active_view)[0] }}")
    })

</script>
@endif
@endpush