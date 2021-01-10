@props(['profile', 'active'])

<form method="POST" action="{{ route('current-profile.update') }}">
    @method('PUT')
    @csrf

    <!-- Hidden Profile ID -->
    <input type="hidden" name="profile_id" value="{{ $profile->id }}">
    @if($active)
    <div class="flex items-center">
        <span class="truncate mr-2 flex-shrink-0 text-blue-700 font-medium">
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
    <div class="grid grid-cols-5 gap-2">
        <div onclick="this.closest('form').submit();" class="cursor-pointer text-blue-700 font-medium col-span-3 mr-3 truncate">
            {{ $profile->full_tag() }}
        </div>

        <div class="col-span-2 flex justify-center items-center">
            <a class="text-blue-600 mr-3" href="{{ $profile->url->visit }}">
                <i class="fas fa-eye"></i>
            </a>
            <a class="text-blue-600 mr-3" href="{{ $profile->url->edit }}">
                <i class="far fa-edit"></i>
            </a>
            @if($profile->isBusiness())
            <a class="text-blue-600 mr-3" href="{{ $profile->url->products }}">
                <i class="fas fa-shopping-bag"></i>
            </a>
            <a class="text-blue-600 mr-3" href="{{ $profile->url->add_product }}">
                <i class="fas fa-plus-circle"></i>
            </a>

            <a class="text-blue-600 mr-3" href="{{ $profile->url->team }}">
                <i class="fas fa-users"></i>
            </a>

            <a class="text-blue-600 mr-3" href="{{ $profile->url->orders }}">
                <i class="fas fa-clipboard-check"></i>
            </a>
            @endif
        </div>
    </div>
    @endif
</form>