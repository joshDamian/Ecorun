<?php

namespace App\Http\Livewire\Connect\Post\Comment;

use App\Http\Livewire\Traits\CreatesSocialContent;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class EditComment extends Component
{
    use CreatesSocialContent,
        AuthorizesRequests;

    public $comment;
    public $gallery;
    public $confirm = false;
    protected $listeners = [
        'refreshMe' => '$refresh'
    ];

    public function mount()
    {
        $this->authorize('update', [$this->comment, auth()->user()->currentProfile]);
        $this->text_content = (string) $this->comment->content;
        if ($this->comment->gallery->count() > 0) {
            $this->hasStoredImages = true;
            $this->gallery = $this->comment->gallery;
        }
    }

    public function confirmDeleteComment()
    {
        $this->confirm = true;
    }

    public function create()
    {
        $this->validate($this->validationRules());
        $this->comment->content = $this->text_content;
        $this->comment->save();
        if (count($this->photos) > 0) {
            $this->uploadPhotos('comment-photos', $this->comment, 'comment_photo');
            $this->photos = [];
            return $this->redirect($this->comment->url->edit);
        }
        return $this->emitSelf('saved');
    }

    public function deleteComment()
    {
        $this->authorize('update', [$this->comment, auth()->user()->currentProfile]);
        $post = $this->comment->feedbackable;
        $this->comment->delete();
        return $this->redirect($post->url->show);
    }

    public function removeFromStoredPhotos($image)
    {
        $image = $this->gallery->find($image);
        if ($this->comment->gallery->count() > 1 || $this->comment->content !== '') {
            $image_url = $image->image_url;
            $image->delete();
            $this->emitSelf('refreshMe');
            return Storage::disk('public')->delete($image_url);
        } else {
            $this->addError('last_content', 'deleting will empty comment content');
        }
    }

    public function extra_validation(): array
    {
        return [];
    }
    public function render()
    {
        return view('livewire.connect.post.comment.edit-comment');
    }
}
