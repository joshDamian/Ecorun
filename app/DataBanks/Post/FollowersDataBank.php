<?php

namespace App\DataBanks\Post;

use App\DataBanks\DataBank;
use App\Models\Feedback;
use App\Models\Connect\Content\Post;
use App\Models\Connect\Profile\Profile;

class FollowersDataBank implements DataBank
{
    protected Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post->loadMissing('comments.replies');
    }

    public function fetch()
    {
        return Profile::whereExists(function ($query) {
            $query->select('profile_id')
                ->from('feedback')
                ->whereColumn('profile_id', 'profiles.id')
                ->where('feedbackable_id', $this->post->id)
                ->where('feedbackable_type', Post::class);
        })
            ->orwhereExists(function ($query) {
                $query->select('profile_id')
                    ->from('feedback')
                    ->whereColumn('profile_id', 'profiles.id')
                    ->whereIn('feedbackable_id', $this->post->comments->pluck('id'))
                    ->where('feedbackable_type', Feedback::class);
            })
            ->orWhereIn('id', $this->post->mentions)
            ->orWhereIn('id', $this->post->comments->pluck('mentions')->flatten()->unique())
            ->orWhereIn('id', $this->post->comments->pluck('replies')->flatten()->pluck('mentions')
                ->flatten()->unique())
            ->orWhere('id', $this->post->profile_id)
            ->distinct()->get();
    }
}
