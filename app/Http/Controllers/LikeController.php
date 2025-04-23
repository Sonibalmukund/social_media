<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
        $user =Auth::user();
        $friends=$user->friends->merge($user->friendOf);
        $friendIds=$friends->pluck('id')->toArray();
        if (!in_array($post->user_id, $friendIds)) {
            return redirect()->back()->with('success','Only friends can like posts');
        }
    
        $like = $post->likes()->where('user_id', $user->id)->first();
    
        if ($like) {
            $like->delete();
            return redirect()->back()->with('success','Unlike The Post');
        } else {
            $post->likes()->create(['user_id' => $user->id]);
            return redirect()->back()->with('success','Like The Post');
        }
    


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
