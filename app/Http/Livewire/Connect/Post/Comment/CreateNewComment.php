<?php

namespace App\Http\Livewire\Connect\Post\Comment;

use App\Http\Livewire\Traits\CreatesSocialContent;
use Livewire\Component;
use App\Models\Profile;

class CreateNewComment extends Component
{
    use CreatesSocialContent;

    public $post;

    public function create()
    {
        $this->validate($this->defaulRules());
        $comment = $this->profile->feedbacks()->create(
            [
                'content' => trim($this->text_content) ?? ''
            ]
        );
        $this->post->comments()->save($comment);
        $this->uploadPhotos('comment-photos', $comment, 'comment_photo', array(1400, 1400));
        $this->emit('addedContent');
        $this->emit('newFeedback');
        $this->done();
        return;
    }

    public function render()
    {
        return view('livewire.connect.post.comment.create-new-comment');
    }
}
