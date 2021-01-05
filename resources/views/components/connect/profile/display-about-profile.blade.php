@props(['profile'])
<div class="bg-white sm:shadow-sm">
    <p class="p-3 text-lg font-medium text-gray-600 border-b border-gray-300">
        About {{ $profile->name }}
    </p>
    <p class="p-3 text-gray-700 text-md">
        {{ $profile->description }}
    </p>
</div>
