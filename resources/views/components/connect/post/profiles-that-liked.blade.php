@props(['post'])
<div>
    @php
    $profiles = $post->likes->pluck('profile')
    @endphp
    @forelse($profiles as $profile)
    <a class="@if(!$loop->last) mb-3 @endif flex items-center" href="{{ $profile->url->visit }}">
        <div style="background-image: url('{{ $profile->profile_photo_url }}'); background-size: cover; background-position: center center;"
            class="w-6 h-6 border-t-2 flex-shrink-0 border-b-2 mr-3 border-blue-700 rounded-full">
        </div>
        <div class="flex-1 dont-break-out text-blue-700 font-semibold truncate">
            {{ ucwords($profile->
            name) }}
        </div>
    </a>
    @empty
    <div>
        no likes yet.
    </div>
    @endforelse
</div>