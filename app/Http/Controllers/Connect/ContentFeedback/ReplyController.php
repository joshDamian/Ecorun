<?php

namespace App\Http\Controllers\Connect\ContentFeedback;

use Illuminate\Http\Request;
use App\Models\Connect\Content\Post;
use App\Models\Connect\ContentFeedback\Feedback;
use App\Http\Controllers\Controller;

class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post, Feedback $comment, Feedback $reply)
    {
        $comment = $comment->loadMissing('profile', 'gallery');
        $reply = $reply->loadMissing('profile', 'gallery');
        $post = $post->loadMissing('profile', 'gallery', 'comments', 'likes', 'shares');
        return view('reply.show', compact('post', 'reply', 'comment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post, Feedback $comment, Feedback $reply)
    {
        $reply = $reply->loadMissing('profile', 'gallery');
        return view('reply.edit', compact('reply'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, Feedback $comment, Feedback $reply)
    {
        $this->authorize('update', [$reply, auth()->user()->currentProfile]);
        $reply = $reply->loadMissing('gallery', 'profile');
        $confirm_delete = true;
        return view('reply.edit', compact('reply', 'confirm_delete'));
    }
}
