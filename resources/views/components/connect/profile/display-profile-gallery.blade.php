@props(['profile'])
<div>
    <div class="grid grid-cols-2 gap-2 sm:grid-cols-4">
        @php $profile_gallery = $profile->gallery @endphp
        @foreach($profile_gallery as $key => $picture_post)
        @foreach($picture_post->gallery as $key => $image)
        <a href="{{ route('post.show', ['post' => $picture_post->id]) }}">
            <img class="w-full h-auto" src="/storage/{{ $image->image_url }}" />
        </a>
        @endforeach
        @endforeach
    </div>
    @if($profile_gallery->isEmpty())
    <div class="p-4 text-blue-700">
        <div class="flex items-center justify-center justify-items-center">
            <i style="font-size: 4rem;" class="far fa-images"></i>
        </div>
        <div class="px-3 pt-3 text-center">
            {{ $profile->name }}'s gallery is empty <i class="far fa-smile"></i>
        </div>
    </div>
    @endif
</div>
