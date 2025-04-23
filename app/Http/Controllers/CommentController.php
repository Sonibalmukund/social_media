<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)
{
    $request->validate([
        'body' => 'required|string|max:1000',
    ]);

    $user = auth()->user();

    // Check friendship or ownership
    $friends = ($user->friend ?? collect())->merge($user->friendOf ?? collect());
    $friendIds = $friends->pluck('id')->toArray();
    $friendIds[] = $user->id; // Include self

    if (!in_array($post->user_id, $friendIds)) {
        return redirect()->back()->with('error', 'Only friends or owner can comment.');
    }

    $post->comments()->create([
        'user_id' => $user->id,
        'body' => $request->body,
    ]);

    return redirect()->back()->with('success', 'Comment added!');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
