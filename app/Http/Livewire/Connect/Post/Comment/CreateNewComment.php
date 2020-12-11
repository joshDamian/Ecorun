<?php

namespace App\Http\Livewire\Connect\Post\Comment;

use App\Http\Livewire\Traits\CreateProfileContent;
use Livewire\Component;

class CreateNewComment extends Component
{
    use CreateProfileContent;

    public $post;

    public function create()
    {
        $this->defaultContentValidation();

        $comment = $this->profile->feedbacks()->create([
            'content' => trim($this->content) ?? ''
        ]);

        $this->post->comments()->save($comment);

        $this->uploadPhotos('comment-photos', $comment, 'comment_photo', array(1400, 1400));

        return $this->done();
    }

    public function render()
    {
        return view('livewire.connect.post.comment.create-new-comment');
    }
}
