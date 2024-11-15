<?php

namespace App\Http\Controllers;

use App\Models\Listadd;
use App\Models\Liste;
use Illuminate\Http\Request;

class ListaddController extends Controller
{
    public function listemovies($liste_id)
    {
        try {
            // Find the list by ID
            $liste = Liste::find($liste_id);
    
            // Check if the list exists
            if (!$liste) {
                return response()->json([
                    'success' => false,
                    'message' => 'List not found.',
                ], 404);
            }
    
            // Fetch all movies associated with the list
            $movies = $liste->movies; // Assuming a `movies` relationship is defined in the `Liste` model
    
            // Check if the list is empty
            if ($movies->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'message' => 'The list is empty.',
                    'data' => [],
                ], 200);
            }
    
            // Return success response with movies
            return response()->json([
                'success' => true,
                'message' => 'Movies fetched successfully.',
                'data' => $movies,
            ], 200);
    
        } catch (\Exception $e) {
            // Handle unexpected errors
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching the movies.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function addmovie(Request $request)
    {
        // Validate incoming request to ensure both movie_id and liste_id are provided
        $validatedData = $request->validate([
            'movie_id' => 'required|string|max:255', // Adjust validation rules for movie_id
            'liste_id' => 'required|exists:listes,id', // Ensure liste_id exists in the listes table
        ]);
    
        try {
            // Retrieve the list by the liste_id from the request
            $liste = Liste::find($validatedData['liste_id']);
    
            // Check if the list exists
            if (!$liste) {
                return response()->json([
                    'success' => false,
                    'message' => 'List not found.',
                ], 404);
            }
    
            // Add the movie to the list
            $liste->movies()->create([  // Assuming 'movies' is a valid relationship method in the Liste model
                'movie_id' => $validatedData['movie_id'],
            ]);
    
            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Movie added to the list successfully.',
            ], 201);
    
        } catch (\Exception $e) {
            // Handle unexpected errors
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the movie.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function deletemovie( $movie_id,$liste_id)
{
    try {
        // Find the list by liste_id
        $liste = Liste::find($liste_id);
    
        // Check if the list exists
        if (!$liste) {
            return response()->json([
                'success' => false,
                'message' => 'List not found.',
            ], 404);
        }

        // Find the movie in the listadd relationship and delete it
        $movie = $liste->movies()->where('movie_id', $movie_id)->first();

        // Check if the movie exists in the list
        if (!$movie) {
            return response()->json([
                'success' => false,
                'message' => 'Movie not found in this list.',
            ], 404);
        }

        // Delete the movie from the list
        $movie->delete();

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Movie deleted from the list successfully.',
        ], 200);

    } catch (\Exception $e) {
        // Handle unexpected errors
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while deleting the movie.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

    
}
