<?php

namespace App\Http\Controllers;

use App\Models\Watchlist;
use Illuminate\Http\Request;

class WatchlistController extends Controller
{
    public function userwatchlist(Request $request)
    {
        $user = $request->user();
        $watchlist = $user->watchlists;  // Retrieve watchlists for the authenticated user
        
        if ($watchlist->isEmpty()) {
            return response()->json([
                'message' => 'Your watchlist is empty.',
            ], 200);  // Return a message if the watchlist is empty
        }
    
        return response()->json([
            'watchlist' => $watchlist,
        ], 200);  // Return the watchlist items if not empty
    }
        public function insertWatchlist(Request $request)
{
    // Get the currently authenticated user
    $user = $request->user();
    
    // Validate the incoming request data
    $request->validate([
        'movie_id' => 'required|string|unique:watchlists,movie_id,NULL,id,user_id,' . $user->id
    ], [
        'movie_id.required' => 'The movie ID is required.',
        'movie_id.string' => 'The movie ID must be a valid string.',
        'movie_id.unique' => 'This movie is already in your watchlist.'
    ]);
    
    try {
        // Create the new watchlist entry
        $watchlist = Watchlist::create([
            'user_id' => $user->id,
            'movie_id' => $request->movie_id,
        ]);
    
        // Return a success message along with the created watchlist data
        return response()->json([
            'message' => 'New movie added to your watchlist successfully!',
            'watchlist' => $watchlist
        ], 201);

    } catch (\Exception $e) {
        // Handle any errors that might occur during the creation process
        return response()->json([
            'message' => 'Failed to add movie to watchlist.',
            'error' => $e->getMessage()
        ], 500);
    }
}

    

    public function deleteWatchlist( Request $request,$movie_id)
    {
        $user=$request->user();
        $watchlist = Watchlist::where('user_id',$user->id)->where('movie_id',$movie_id);
        $watchlist->delete();
        return response()->json(['message'=>'movie deleted from your watchlist']);
    }
}
