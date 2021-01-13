<?php

use App\Models\Profile;
use Illuminate\Support\Facades\Broadcast;
use App\Models\DirectConversation;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel(
    'App.Models.User.{id}',
    function ($user, $id): bool {
        return (int) $user->id === (int) $id;
    }
);

Broadcast::channel(
    'App.Models.Profile.{id}',
    function ($user, Profile $id): bool {
        return $user->associated_profiles->all->contains($id);
    }
);

Broadcast::channel('private_conversation.{conversationId}', function ($user, DirectConversation $conversationId) {
    $concernedProfile = $user->associated_profiles->all->filter(function($profile) use($user, $conversationId) {
        return $user->can('view', [$conversationId, $profile]);
    })->first();

    if ($concernedProfile) {
        return ['id' => $concernedProfile->id,
            'name' => $concernedProfile->name];
    }
    return false;
});