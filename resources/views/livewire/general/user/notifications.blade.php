<div>
    <div class="grid grid-cols-1 gap-2">
        <div class="md:hidden">
            <div wire:loading class="w-full">
                <x-loader />
            </div>
        </div>

        @if($display)
        @forelse(Auth::user()->currentProfile->notifications as $key => $notification)
        <div>
            @if($notification->type === "App\Notifications\PostCreated")
            @php
            $post = App\Models\Post::find($notification->data['post_id']);
            @endphp
            <a class="block p-2 bg-gray-100" href="{{ route('post.show', ['post' => $notification->data['post_id']]) }}">
                <div class="flex items-start">
                    <div style="background-image: url('{{ $post->profile->profile_photo_url }}'); background-size: cover; background-position: center center;" class="flex-shrink-0 w-12 h-12 border-t-2 border-b-2 border-blue-700 rounded-full">
                    </div>

                    <div class="grid flex-1 grid-cols-1 ml-3 text-blue-700">
                        <div class="flex justify-between">
                            <div class="flex-1 font-bold">{{ $notification->data['title'] }}</div>

                            <div class="flex-shrink-0 ml-3 text-gray-700">
                                {{ $notification->created_at->diffForHumans(null, null, true) }}
                            </div>
                        </div>
                        <span class="text-gray-700">
                            <span class="font-semibold text-black">
                                {{ $post->profile->name }}
                            </span>
                            added a new post.
                        </span>

                        @if($post->content)
                        <p class="text-sm font-normal text-gray-900 truncate">
                            <span class="text-blue-600"><i class="fas fa-arrow-alt-circle-right"></i></span> {{ $post->content }}
                        </p>
                        @endif
                    </div>
                </div>
            </a>
            @endif
        </div>
        @empty
        <div class="p-6">
            <div class="flex items-center justify-center">
                <i style="font-size: 6rem;" class="text-blue-700 far fa-bell"></i>
            </div>

            <div class="pt-3 text-lg font-semibold text-center text-blue-700">no new notifications</div>
        </div>
        @endforelse
        @endif
    </div>
</div>
