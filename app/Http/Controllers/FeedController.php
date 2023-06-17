<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    public function saveFeed(Request $request)
    {
        $request->validate([
            'source' => 'string|required|not_in:all',
            'category' => 'string|required|not_in:all',
        ]);

        $feed = Feed::updateOrCreate([
            'user_id' => Auth::user()->id,
        ], [
            'user_id' => Auth::user()->id,
            'source' => $request->source,
            'category' => $request->category,
        ]);

        return response()->json(['success' => true, 'data' => $feed]);
    }

    public function getFeed()
    {
        $feed = Auth::user()->feed;

        return response()->json(['success' => true, 'data' => $feed]);
    }
}
