<?php

namespace App\Http\Livewire\Connect\Post\Comment;

use App\Http\Livewire\Connect\Traits\CreateNewContent;
use Livewire\Component;

class CreateNewComment extends Component
{
    use CreateNewContent;

    public $post;

    public function create()
    {
        $this->defaultContentValidation();

        $comment = $this->post->comments()->create([
            'content' => trim($this->content) ?? ''
        ]);

        $this->profile->feedbacks()->save($comment);

        $this->uploadPhotos('comment-photos', $comment, 'comment_photo', array(1400, 1400));

        return $this->done();
    }

    public function render()
    {
        return view('livewire.connect.post.comment.create-new-comment');
    }
}
