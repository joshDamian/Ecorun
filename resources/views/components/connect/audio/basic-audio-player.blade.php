@props(['audio'])
<div>
    <audio class="w-full px-2 py-1 bg-blue-300 border-none rounded-lg shadow-md outline-none"
        src="/storage/{{ $audio->url }}" controls></audio>
</div>
