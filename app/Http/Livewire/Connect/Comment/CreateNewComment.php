<?php

namespace App\Http\Livewire\Connect\Comment;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;

class CreateNewComment extends Component
{
    use WithFileUploads;

    public $profile;
    public $photos = [];
    public $content;
    public $view;
    public $title;
    public $commentable;
    public $ready;

    public function create()
    {
        $this->validate([
            'title' => [
                Rule::requiredIf($this->view === 'review'),
                ($this->view !== 'review') ? 'nullable' : '', 
                'min:4', 'max:255',
            ],
            'content' => Rule::requiredIf(count($this->photos) === 0),
            'photos' => Rule::requiredIf(empty(trim($this->content))),
            'photos.*' => ['image', 'max:5120']
        ]);

        $comment = $this->commentable->comments()->create([
            'content' => trim($this->content) ?? '',
        ]);

        $this->profile->comments()->save($comment);

        if (count($this->photos) > 0) {
            foreach ($this->photos as $photo) {
                $photo_path = $photo->store('post-photos', 'public');
                /* $photo = Image::make(public_path("/storage/{$photo_path}"))->fit(1400, 1400, function ($constraint) {
                    $constraint->upsize();
                });
                $photo->save(); */

                $comment->gallery()->create([
                    'image_url' => $photo_path,
                    'label' => 'comment_photo'
                ]);
            }
        }

        return $this->done();
    }

    public function done()
    {
        $this->ready = null;
        $this->photos = [];
        $this->content = null;
        $this->title = null;
        return $this->resetErrorBag();
    }

    public function ready()
    {
        $this->ready = true;
    }

    public function updatedPhotos()
    {
        $this->validate([
            'photos.*' => ['image', 'max:5120']
        ]);
    }

    public function render()
    {
        return view('livewire.connect.comment.create-new-comment');
    }
}
