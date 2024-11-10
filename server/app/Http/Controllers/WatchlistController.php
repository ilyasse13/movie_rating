<?php

namespace App\Http\Controllers;

use App\Models\Watchlist;
use Illuminate\Http\Request;

class WatchlistController extends Controller
{
    public function getallwatchlist(Request $request)
    {
        $user = $request->user();
        $watchlist = $user->watchlists; 
    }
}
