<?php

namespace App\Http\Livewire\Connect\Post\Comment\Reply;

use Livewire\Component;
use App\Http\Livewire\Traits\CreatesSocialContent;

class CreateNewReply extends Component
{
    use CreatesSocialContent;

    public $comment;

    public function create() {
        $this->validate($this->validationRules());
        $reply = $this->profile->feedbacks()->create(
            [
                'content' => trim($this->text_content) ?? ''
            ]
        );

        $reply = $this->comment->replies()->save($reply);

        if (count($this->photos) > 0) {
            $this->uploadPhotos('reply-photos', $reply, 'reply_photo');
        }

        $this->emit('addedContent');
        $this->emit('newFeedback');
        // broadcast(new CommentedOnPost($comment))->toOthers();
        $this->done();
        return;
    }

    public function extra_validation(): array
    {
        return [];
    }

    public function render() {
        return view('livewire.connect.post.comment.reply.create-new-reply');
    }
}