@props(['audio'])
<div>
    <div class="flex justify-end px-3 py-3 bg-gray-100 sm:px-5">
        <x-jet-secondary-button>
            <i class="fas fa-folder-plus"></i>
        </x-jet-secondary-button>
    </div>
    <audio class="w-full px-2 py-1 bg-blue-300 border-none rounded-lg shadow-md outline-none"
        src="/storage/{{ $audio->url }}" controls></audio>
</div>
