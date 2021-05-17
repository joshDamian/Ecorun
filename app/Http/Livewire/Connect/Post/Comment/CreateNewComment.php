<?php

namespace App\Http\Livewire\Connect\Post\Comment;

use App\Http\Livewire\Traits\CreatesSocialContent;
use Livewire\Component;
use App\Models\Connect\ContentFeedback\Feedback;

class CreateNewComment extends Component
{
    use CreatesSocialContent;

    public $post;

    public function create()
    {
        $this->validate($this->validationRules());
        $comment = Feedback::forceCreate([
            'content' => trim($this->text_content) ?? '',
            'feedbackable_type' => get_class($this->post),
            'feedbackable_id' => $this->post->id,
            'profile_id' => $this->profile->id
        ]);

        if (count($this->photos) > 0) {
            $this->uploadPhotos(photos: $this->photos, folder: 'comment-photos', imageable: $comment, label: 'comment_photo', sizes: null);
        }

        $this->post->forceFill([
            'updated_at' => now()
        ])->save();
        $this->done();
        $this->emit('addedContent');
        return $this->emit('newFeedback');
    }

    public function extra_validation(): array
    {
        return [];
    }

    public function render()
    {
        return view('livewire.connect.post.comment.create-new-comment');
    }
}
