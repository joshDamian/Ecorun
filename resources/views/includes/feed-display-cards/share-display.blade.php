<div>
    @php
    $share = $model;
    $profile = $share->profile;
    $profile_visit_url = $profile->url->visit;
    @endphp

    <div class="bg-gray-100">
        <div class="flex justify-between px-3 py-3 border-b border-gray-200 sm:px-5 sm:py-3 sm:p-0">
            <div class="flex items-center flex-1">
                <a class="mr-3" href="{{ $profile_visit_url }}">
                    <div style="background-image: url('{{ $profile->profile_photo_url }}'); background-size: cover; background-position: center center;"
                        class="w-10 h-10 border-t-2 border-b-2 border-blue-700 rounded-full">
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
                            {{ $share->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-3 py-3 border-b border-gray-300 sm:px-5">
            <a href="{{ $profile->url->visit }}"
                class="font-bold text-blue-700">{{ ($profile->id === Auth::user()->currentProfile->id) ? 'You' : $profile->name }}</a>
            shared a
            {{ strtolower(last(explode('\\', get_class($share->shareable)))) }}.
        </div>
    </div>

    <div>
        @switch($share->shareable_type)
        @case('App\Models\Post')
        @include('includes.feed-display-cards.post-display', ['model' => $share->shareable])
        @break
        @case('App\Models\Product')
        @include('includes.feed-display-cards.product-display', ['model' => $share->shareable])
        @break
        @default
        @break
        @endswitch
    </div>
</div>