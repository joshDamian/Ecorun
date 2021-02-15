<div class="flex flex-wrap font-hairline">
    <a href="{{ $profile->url->following }}" class="mr-3">
        <span class="font-semibold text-blue-800">{{ $following }}</span> <span class="text-gray-600">Following</span>
    </a>

    <a href="{{ $profile->url->followers }}">
        <span class="font-semibold text-blue-800">{{ $followers }}</span> <span class="text-gray-600">Followers</span>
    </a>
</div>