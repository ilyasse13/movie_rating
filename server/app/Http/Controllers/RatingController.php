<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function getMovieRating($movie_id)
    {
        // Calculate the average rating for the specified movie_id
        $averageRating = Rating::where('movie_id', $movie_id)->avg('rate');

        // Return the result as a JSON response
        return response()->json([
            'movie_id' => $movie_id,
            'users_rating' => $averageRating ?? 0, // Return 0 if there are no ratings
        ], 200);
    }
    public function getAllMoviesAverageRatings()
    {
        // Get average ratings for each movie_id
        $averageRatings = Rating::select('movie_id')
            ->selectRaw('AVG(rate) as average_rating')
            ->groupBy('movie_id')
            ->get();

        // Return the results as a JSON response
        return response()->json([
            'average_ratings' => $averageRatings
        ], 200);
    }
    public function addRating(Request $request)
    {
        $user=$request->user();
        $request->validate([
            'movie_id' => 'required|string',
            'rate' => 'required|numeric|min:0|max:10' // Assuming ratings are on a 0-10 scale
        ]);
        $rating = Rating::create([
            'movie_id' => $request->movie_id,
            'rate' => $request->rate,
            'user_id' => $user->id
        ]) ;
        return response()->json([
            'message' => 'Rating added successfully',
      ], 201);

    }
}
