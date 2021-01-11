<div class="sm:grid sm:grid-cols-4">
    <div class="sm:col-span-3">
        @foreach($this->current_conversations as $conversation)
        @if($conversion insta)
        @php $pair = $conversation->getPair($profile->id) @endphp
        <div class="flex items-center p-3 bg-gray-100 shadow sm:p-0 sm:px-3 sm:py-3">
            <div style="background-image: url('{{ $pair->profile_photo_url }}'); background-size: cover; background-position: center center;"
                class="flex-shrink-0 w-12 h-12 mr-3 border-t-2 border-b-2 border-blue-700 rounded-full">
            </div>

            <div class="grid flex-1 flex-shrink-0 grid-cols-1">
                <div class="flex items-center justify-between">
                    <div class="flex-1 flex-shrink-0 font-semibold text-blue-700 truncate">
                        {{ ucfirst(strtolower($pair->name)) }}
                    </div>

                    <div class="flex justify-end flex-shrink-0 font-medium text-gray-800">
                        {{ $conversation->updated_at->diffForHumans(null, true, true) }}
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex-1 flex-shrink-0 font-medium text-gray-900 truncate">
                        {{ $conversation->messages->first()->content }}
                    </div>

                    @if($conversation->unread_messages_count > 0)
                    <span class="flex-shrink-0 fa-stack fa-1x">
                        <i style="font-size: 23px;" class="text-red-600 far fa-circle fa-stack-1x"></i>
                        <span
                            class="text-xs font-extrabold text-red-600 fa-stack-1x">{{ $conversation->unread_messages_count  }}</span>
                    </span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
