@props(['profile', 'freshNotifications' => $profile->loadMissing('unreadNotifications')->unreadNotifications()->whereNotIn('id', Cache::get($profile->id.'_notifications', collect([]))->pluck('id'))->get()])
<div class="grid grid-cols-1 gap-2">
    @php

    if($freshNotifications->count() > 0) {
    Cache::put($profile->id.'_notifications', Cache::get($profile->id.'_notifications', collect([]))->concat($freshNotifications));
    }

    $notifications = Cache::remember($profile->id.'_notifications', now()->addDays(30), function() use ($profile) {
    return $profile->loadMissing('notifications')->notifications;
    })->sortByDesc('created_at');

    $post_notifications = $notifications->filter(function($value, $key) {
    return $value->type === 'App\Notifications\PostCreated';
    });
    $posts = App\Models\Post::whereIn('id', $post_notifications->pluck('data.post_id'))->get()->loadMissing('profile');
    @endphp

    @forelse($notifications as $notification)
    @if($notification->type === 'App\Notifications\PostCreated')
    <x-connect.notification.post-created-display :notification="$notification" :post="$posts->find($notification->data['post_id'])->loadMissing('profile')" />
    @endif
    @empty
    <div class="p-3 text-blue-700">
        <div class="flex items-center justify-center justify-items-center">
            <i style="font-size: 8rem;" class="far fa-bell"></i>
        </div>
        <div class="pt-3 text-lg font-semibold text-center">no notifications yet.</div>
    </div>
    @endforelse
</div>
