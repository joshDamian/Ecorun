@props(['profile'])
<div class="grid grid-cols-1 gap-2">
    @php
    $notifications = Cache::remember($profile->id.'_notifications', now()->addDays(30), function() use ($profile) {
    return $profile->loadMissing('notifications')->notifications;
    });
    $post_notifications = $notifications->filter(function($value, $key) {
    return $value->type === 'App\Notifications\PostCreated';
    });
    $posts = App\Models\Post::whereIn('id', $post_notifications->pluck('data.post_id'))->get()->loadMissing('profile');
    @endphp

    @foreach($notifications as $notification)
    @if($notification->type === 'App\Notifications\PostCreated')
    <x-connect.notification.post-created-display :notification="$notification" :post="$posts->find($notification->data['post_id'])->loadMissing('profile')" />
    @endif
    @endforeach
</div>
