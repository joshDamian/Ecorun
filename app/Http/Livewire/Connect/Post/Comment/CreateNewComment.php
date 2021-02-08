<?php

namespace App\Http\Livewire\Connect\Post\Comment;

use App\Http\Livewire\Traits\CreatesSocialContent;
use Livewire\Component;

class CreateNewComment extends Component
{
    use CreatesSocialContent;

    public $post;

    public function create()
    {
        $this->validate($this->validationRules());
        $comment = $this->profile->feedbacks()->create(
            [
                'content' => trim($this->text_content) ?? ''
            ]
        );
        $this->post->comments()->save($comment);
        $this->uploadPhotos('comment-photos', $comment, 'comment_photo');
        $this->emit('addedContent');
        $this->emit('newFeedback');
        $this->done();
        return;
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
