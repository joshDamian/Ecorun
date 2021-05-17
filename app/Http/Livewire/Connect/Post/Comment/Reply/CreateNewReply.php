<?php

namespace App\Http\Livewire\Connect\Post\Comment\Reply;

use Livewire\Component;
use App\Http\Livewire\Traits\CreatesSocialContent;
use App\Events\FeedbackEvents\RepliedToComment;
use App\Models\Connect\ContentFeedback\Feedback;

class CreateNewReply extends Component
{
    use CreatesSocialContent;

    public $comment;

    public function create()
    {
        $this->validate($this->validationRules());
        $reply = Feedback::forceCreate([
            'content' => trim($this->text_content) ?? '',
            'feedbackable_type' => get_class($this->comment),
            'feedbackable_id' => $this->comment->id,
            'profile_id' => $this->profile->id
        ]);

        if (count($this->photos) > 0) {
            $this->uploadPhotos(photos: $this->photos, folder: 'reply-photos', imageable: $reply, label: 'reply_photo', sizes: null);
        }

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
        return view('livewire.connect.post.comment.reply.create-new-reply');
    }
}
