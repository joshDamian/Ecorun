<?php

namespace App\Http\Livewire\Connect\Post;

use App\Http\Livewire\Traits\CreatesSocialContent;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class EditPost extends Component
{
    use CreatesSocialContent,
    AuthorizesRequests;

    public $post;
    public $gallery;
    public $confirm = false;
    protected $listeners = [
        'refreshMe' => '$refresh'
    ];

    public function mount() {
        $this->authorize('update', [$this->post, auth()->user()->currentProfile]);
        $this->text_content = (string) $this->post->content;
        if ($this->post->gallery->count() > 0) {
            $this->hasStoredImages = true;
            $this->gallery = $this->post->gallery;
        }
    }

    public function confirmDeletePost() {
        $this->confirm = true;
    }

    public function create() {
        $this->validate($this->validationRules());
        $this->post->content = $this->text_content;
        $this->post->save();
        if (count($this->photos) > 0) {
            $this->uploadPhotos('post-photos', $this->post, 'post_photo');
            $this->photos = [];
            return $this->redirect($this->post->url->edit);
        }
        return $this->emitSelf('saved');
    }

    public function deletePost() {
        $this->authorize('update', [$this->post, auth()->user()->currentProfile]);
        $this->post->trash();
        return $this->redirect(route('home'));
    }

    public function removeFromStoredPhotos($image) {
        $image = $this->gallery->find($image);
        if ($this->post->gallery->count() > 1 || $this->post->content !== '') {
            $image_url = $image->image_url;
            $image->delete();
            $this->emitSelf('refreshMe');
            return Storage::disk('public')->delete($image_url);
        } else {
            $this->addError('last_content', 'deleting will empty post content');
        }
    }

    public function extra_validation(): array
    {
        return [];
    }


    public function render() {
        return view('livewire.connect.post.edit-post');
    }
}