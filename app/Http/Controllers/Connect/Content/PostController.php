<?php

namespace App\Http\Controllers\Connect\Content;

use App\Models\Connect\Content\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class PostController extends Controller
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Connect\Content\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post = $post->loadMissing('gallery', 'likes', 'comments', 'profile');
        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Connect\Content\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->authorize('update', [$post, Auth::user()->currentProfile]);
        $post = $post->loadMissing('gallery', 'profile');
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Connect\Content\Post         $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Connect\Content\Post $post
     * @return \Illuminate\Http\Response
     */

    public function destroy(Post $post)
    {
        $this->authorize('update', [$post, Auth::user()->currentProfile]);
        $post = $post->loadMissing('gallery', 'profile');
        $confirm_delete = true;
        return view('post.edit', compact('post', 'confirm_delete'));
    }
}
