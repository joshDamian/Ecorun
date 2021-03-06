<div>
    @php
    $profile = $model;
    $profile_visit_url = $profile->url->visit;
    @endphp
    <div class="flex flex-col p-3 bg-gray-100 sm:flex-row">
        <div class="flex items-center justify-center flex-shrink-0 mb-3 sm:mr-3 sm:mb-0">
            <a href="{{ $profile_visit_url }}">
                <div style="background-image: url('{{ $profile->profile_photo_url }}'); background-size: cover; background-position: center center;"
                    class="border-t-2 border-b-2 border-blue-700 rounded-full w-28 h-28 sm:w-16 sm:h-16">
                </div>
            </a>
        </div>

        <div class="flex items-start flex-1 flex-shrink-0 sm:items-center">
            <div class="flex-1 flex-shrink mr-3">
                <div>
                    <a href="{{ $profile_visit_url }}">
                        <span class="font-bold text-blue-700 text-md dont-break-out">{{ $profile->name }}</span>
                    </a> @if($profile->isOnline()) &nbsp; <i class="text-sm text-green-400 fas fa-circle"></i> @endif
                </div>
                <div>
                    <a href="{{ $profile_visit_url }}">
                        <span
                            class="font-semibold text-blue-700 dont-break-out text-md">{{ $profile->full_tag() }}</span>
                    </a>
                </div>
                <div>
                    @livewire('connect.profile.following-followers-counter', ['profile' => $profile], key(microtime() .
                    'ff_counter' . $profile->id))
                </div>
            </div>
            <div class="grid grid-cols-1 gap-2">
                <div class="font-bold text-green-500">
                    <i class="fas fa-check-circle"></i> {{ $profile->profileable?->primaryBadge->label }}
                </div>
                <div class="flex items-center justify-end">
                    @livewire('connect.profile.follow-profile', ['profile' => $profile], key(microtime() .
                    str_shuffle($profile->tag) . $profile->id))
                </div>
            </div>
        </div>
    </div>

    <div class="px-3 py-3 font-semibold text-gray-700 bg-gray-50">
        {{ $profile->description }}
    </div>
</div>