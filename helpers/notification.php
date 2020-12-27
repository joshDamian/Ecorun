<?php
use Illuminate\Support\Facades\Auth;

function notifications_count():int
{
    $user = Auth::user()->loadMissing('profile');
    return
        $user->associatedProfiles()->concat([$user->profile])->loadCount('unreadNotifications')->map(
            function ($profile):int {
                return $profile->unread_notifications_count;
            }
        )->sum();
}
