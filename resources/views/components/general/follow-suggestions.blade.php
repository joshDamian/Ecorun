<div class="flex overflow-x-auto">
    @foreach($profiles as $profile)
    <div class="flex justify-center p-4 bg-gray-200">
        <div class="border-t-4 border-b-4 border-blue-700 rounded-full w-36 h-36 md:h-44 md:w-44"
            style="background-image: url('{{ $profile->profile_photo_url }}'); background-size: cover; background-position: center center; background-repeat: no-repeat;">
        </div>
    </div>
    @endforeach
</div>