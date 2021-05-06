@props(['profile', 'active'])

<form method="POST" action="{{ route('current-profile.update') }}">
    @method('PUT')
    @csrf

    <!-- Hidden Profile ID -->
    <input type="hidden" name="profile_id" value="{{ $profile->id }}">
    @if($active)
    <div class="flex items-center select-none">
        <span class="flex-shrink-0 mr-2 font-medium text-blue-700 truncate">
            {{ $profile->full_tag() }}
        </span>

        <span classs="flex-shrink-0">
            <svg class="w-5 h-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round"
                stroke-width="3" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </span>
    </div>

    @else
    <div class="grid grid-cols-5 gap-1 select-none">
        <div onclick="this.closest('form').submit();"
            class="col-span-2 mr-2 font-medium text-blue-700 truncate cursor-pointer hover:bg-blue-200">
            {{ $profile->full_tag() }}
        </div>

        <div class="flex flex-wrap items-center justify-start col-span-3">
            <a class="mr-2 text-blue-600" href="{{ $profile->url->visit }}">
                <i class="fas fa-eye"></i>
            </a>
            <a class="mr-2 text-blue-600" href="{{ $profile->url->edit }}">
                <i class="far fa-edit"></i>
            </a>
            @if($profile->isBusiness())
            <a class="mr-2 text-blue-600" href="{{ $profile->profileable->url->warehouse }}">
                <i class="fas fa-shopping-bag"></i>
            </a>
            <a class="mr-2 text-blue-600" href="{{ $profile->profileable->url->sell }}">
                <i class="fas fa-plus-circle"></i>
            </a>
            <a class="mr-2 text-blue-600" href="{{ $profile->profileable->url->team }}">
                <i class="fas fa-users"></i>
            </a>
            <a class="text-blue-600" href="{{ $profile->profileable->url->orders }}">
                <i class="fas fa-clipboard-check"></i>
            </a>
            @endif
        </div>
    </div>
    @endif
</form>
