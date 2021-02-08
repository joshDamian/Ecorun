<div x-data x-init="() => {
        window.addEventListener('beforeunload', (event) => {
            event.preventDefault();
            event.returnValue='';
        });
    }" x-cloak>
    <div class="sticky z-40 px-3 py-1 mb-3 bg-gray-100 bg-opacity-75 top-12 sm:px-5">
        <div class="flex-1 text-lg font-bold text-center text-blue-700">
            <span class="text-gray-700">edit</span> {{ $profile->full_tag() }}'s <span
                class="text-gray-700">post.</span>
        </div>
    </div>

    <div wire:loading wire:target="removeFromStoredPhotos" class="w-full">
        <x-loader_2 />
    </div>

    <x-connect.content.create-new-content :photos="$photos" :profilePhotoUrl="$profile->profile_photo_url"
        type="edit post" />
</div>
