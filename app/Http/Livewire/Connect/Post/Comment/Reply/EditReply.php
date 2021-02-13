<?php

namespace App\Http\Livewire\Connect\Post\Comment\Reply;

use App\Http\Livewire\Traits\CreatesSocialContent;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class EditReply extends Component
{
    use CreatesSocialContent,
    AuthorizesRequests;

    public $reply;
    public $gallery;
    public $confirm = false;
    protected $listeners = [
        'refreshMe' => '$refresh'
    ];

    public function mount() {
        $this->authorize('update', [$this->reply, auth()->user()->currentProfile]);
        $this->text_content = (string) $this->reply->content;
        if ($this->reply->gallery->count() > 0) {
            $this->hasStoredImages = true;
            $this->gallery = $this->reply->gallery;
        }
    }

    public function confirmDeleteReply() {
        $this->confirm = true;
    }

    public function create() {
        $this->validate($this->validationRules());
        $this->reply->content = $this->text_content;
        $this->reply->save();
        if (count($this->photos) > 0) {
            $this->uploadPhotos('reply-photos', $this->reply, 'reply_photo');
            $this->photos = [];
            return $this->redirect($this->reply->url->edit);
        }
        return $this->emitSelf('saved');
    }

    public function deleteComment() {
        $this->authorize('update', [$this->reply, auth()->user()->currentProfile]);
        $comment = $this->reply->feedbackable;
        $this->reply->delete();
        return $this->redirect($comment->url->show);
    }

    public function removeFromStoredPhotos($image) {
        $image = $this->gallery->find($image);
        if ($this->reply->gallery->count() > 1 || $this->reply->content !== '') {
            $image_url = $image->image_url;
            $image->delete();
            $this->emitSelf('refreshMe');
            return Storage::disk('public')->delete($image_url);
        } else {
            $this->addError('last_content', 'deleting will empty reply content');
        }
    }

    public function extra_validation(): array
    {
        return [];
    }

    public function render() {
        return view('livewire.connect.post.comment.reply.edit-reply');
    }
}