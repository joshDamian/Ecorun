@props(['profile'])
<div class="grid grid-cols-1 gap-2">
    @php
    $notifications = $profile->loadMissing('notifications')->notifications;
    $post_notifications = $notifications->filter(function($value, $key) {
    return $value->type === 'App\Notifications\PostCreated';
    });
    $posts = App\Models\Post::with(['profile' => function($query) {
    return $query->cacheFor(3600);
    }])->withCount('gallery')->whereIn('id', $post_notifications->pluck('data.post_id'))->get()->loadMissing('profile');
    @endphp

    @forelse($notifications as $notification)
    @if($notification->type === 'App\Notifications\PostCreated')
    @php
    $post = $posts->find($notification->data['post_id']);
    if(is_null($post)) {
    $notification->delete();
    $this->emit('deletedStuff');
    continue;
    }
    @endphp
    <x-connect.notification.post-created-display :notification="$notification" :post="$post" />
    @endif
    @empty
    <div class="p-3 text-blue-700">
        <div class="flex items-center justify-center justify-items-center">
            <i style="font-size: 5rem;" class="far fa-bell"></i>
        </div>
        <div class="pt-3 text-lg font-semibold text-center">no notifications yet.</div>
    </div>
    @endforelse
</div>
