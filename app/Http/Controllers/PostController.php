<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $friendIds = $user->friends->pluck('id')->toArray();
        $friendIds[] = $user->id; 

        $posts = Post::whereIn('user_id', $friendIds)->orderBy('created_at', 'desc')->get();

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Auth::user()->posts()->create([
            'content' => $request->content,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }
}

