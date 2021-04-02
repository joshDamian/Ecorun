@props(['music', 'audioPlayerType' => 'basic'])
<div>
    <div class="px-3 py-3 font-bold text-blue-700 bg-gray-100 sm:px-5">
        Music: {{ $music->artiste }} - {{ $music->title }}
    </div>

    <div class="flex justify-start px-3 py-3 bg-gray-200 sm:px-5">
        <x-jet-secondary-button>
            <i class="fas text-lg text-blue-700 fa-folder-plus"></i>
        </x-jet-secondary-button>
    </div>

    <div class="px-3 py-3 sm:px-5">
        <figure class="w-full">
            <img src="{{ $music->cover_art }}" class="w-full" />
        </figure>
        <x-connect.audio.audio-player :audio="$music->audio" :type="$audioPlayerType" />
    </div>
</div>