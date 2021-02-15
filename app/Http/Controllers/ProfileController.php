<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index() {
        //
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create() {
        //
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request) {
        //
    }


    /**
    * Display the specified resource.
    *
    * @param  \App\Models\Profile $profile
    * @return \Illuminate\Http\Response
    */
    public function show(Profile $profile, $action_route = null) {
        return view('profile-dashboard.show', compact('profile', 'action_route'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\Profile $profile
    * @return \Illuminate\Http\Response
    */
    public function edit(Profile $profile) {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @param  \App\Models\Profile      $profile
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Profile $profile) {
        //
    }

    public function updateCurrentProfile(Request $request) {
        $request->user()->switchProfile(Profile::findOrFail($request->input('profile_id')));
        return back();
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Profile $profile
    * @return \Illuminate\Http\Response
    */
    public function destroy(Profile $profile) {
        //
    }

    public function followers(Profile $profile) {
        $followers = $profile->followers()->paginate(15);
        return view('profile.followers', compact('profile', 'followers'));
    }

    public function following(Profile $profile) {
        $followings = $profile->following()->paginate(15);
        return view('profile.following', compact('profile', 'followings'));
    }
}