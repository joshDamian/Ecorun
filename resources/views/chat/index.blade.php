<x-social-layout>
    <div class="p-4">
        <div class="grid grid-cols-1 gap-2 py-3">
            @foreach($profile->conversations->all as $conversation)
            @php $pair = $conversation->getPair($profile->id) @endphp
            <div style="background-image: url('{{ $pair->profile_photo_url }}'); background-size: cover; background-position: center center;"
                class="w-12 h-12 border-t-2 border-b-2 border-blue-700 rounded-full">
            </div>
            @endforeach
        </div>
    </div>
</x-social-layout>
