@props(['music', 'audioPlayerType' => 'basic'])
<div>
    <div class="px-3 py-3 font-bold text-blue-700 bg-gray-200 sm:px-5">
        Music: {{ $music->artiste }} - {{ $music->title }}
    </div>
    <div class="px-3 py-3 sm:px-5">
        <figure class="w-full">
            <img src="{{ $music->cover_art }}" class="w-full" />
        </figure>
        <x-connect.audio.audio-player :audio="$music->audio" :type="$audioPlayerType" />
    </div>
</div>
