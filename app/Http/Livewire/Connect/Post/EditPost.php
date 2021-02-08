<?php

namespace App\Http\Livewire\Connect\Post;

use App\Http\Livewire\Traits\CreatesSocialContent;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class EditPost extends Component
{
    use CreatesSocialContent;

    public $post;
    public $gallery;
    protected $listeners = [
        'refreshMe' => '$refresh'
    ];

    public function mount()
    {
        $this->text_content = $this->post->content;
        if ($this->post->gallery->count() > 0) {
            $this->hasStoredImages = true;
            $this->gallery = $this->post->gallery;
        }
    }

    public function create()
    {
        $this->validate($this->validationRules());
    }

    public function removeFromStoredPhotos($image)
    {
        $key = $image;
        $image = $this->gallery->find($image);
        Storage::disk('public')->delete($image->image_url);
        $image->delete();
        return;
    }

    public function extra_validation(): array
    {
        return [];
    }

    public function render()
    {
        return view('livewire.connect.post.edit-post');
    }
}
