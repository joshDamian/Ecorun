@props(['music', 'audioPlayerType' => 'basic'])
<div>
    <div class="px-3 py-3 font-bold text-blue-700 bg-gray-200 sm:px-5">
        Music: {{ $music->artiste }} - {{ $music->title }}
    </div>
    <div class="px-3 py-3 sm:px-5">
        <x-connect.audio.audio-player :audio="$music->audio" :type="$audioPlayerType" />
    </div>
</div>
