<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function sendRequest($friendId)
    {
        $friend = User::findOrFail($friendId);

        if (Auth::id() == $friend->id) {
            return redirect()->back()->withErrors(['You cannot send a friend request to yourself.']);
        }

        Friend::create([
            'user_id' => Auth::id(),
            'friend_id' => $friend->id,
            'status' => 'pending',
        ]);

        return redirect()->route('friends.index');
    }

    public function acceptRequest($friendId)
    {
        $friendRequest = Friend::where('user_id', $friendId)
            ->where('friend_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();

        $friendRequest->update(['status' => 'accepted']);

        Friend::create([
            'user_id' => Auth::id(),
            'friend_id' => $friendId,
            'status' => 'accepted',
        ]);

        return redirect()->route('friends.index');
    }

    public function declineRequest($friendId)
    {
        $friendRequest = Friend::where('user_id', $friendId)
            ->where('friend_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();

        $friendRequest->delete();

        return redirect()->route('friends.index');
    }

    public function index()
{
    $userId = auth()->id();

    $friends = Friend::where(function ($query) use ($userId) {
        $query->where('user_id', $userId)
              ->orWhere('friend_id', $userId);
    })->where('status', 'accepted')->get();

    $pendingRequests = Friend::where('friend_id', $userId)
        ->where('status', 'pending')
        ->with('user')
        ->get();

    $allUsers = \App\Models\User::all();

    return view('friends.index', compact('friends', 'pendingRequests', 'allUsers'));
}

}

