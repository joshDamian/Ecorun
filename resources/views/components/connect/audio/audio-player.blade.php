@props(['audio', 'type' => 'basic'])
<div>
    <x-dynamic-component :component="'connect.audio.' . $type . '-audio-player'" :audio="$audio" class="mt-4" />
</div>
