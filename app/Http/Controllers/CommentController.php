<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Post;

class CommentController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function edit(Post $post, Feedback $comment) {
        $this->authorize('update', [$comment, auth()->user()->currentProfile]);
        $comment = $comment->loadMissing('feedbackable', 'profile', 'gallery');
        return view('comment.edit', compact('comment'));
    }

    public function show(Post $post, Feedback $comment) {
        return view('comment.show', compact('comment'));
    }

    public function destroy(Post $post, Feedback $comment) {
        $this->authorize('update', [$comment, auth()->user()->currentProfile]);
        $comment = $comment->loadMissing('gallery', 'profile');
        $confirm_delete = true;
        return view('comment.edit', compact('comment', 'confirm_delete'));
    }
}