<?php

namespace App\Http\Controllers;

use App\Models\Liste;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ListeController extends Controller
{
    public function index()
    {
        try {
            // Fetch all lists
            $listes = Liste::all();

            // Check if lists are found
            if ($listes->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No lists found.',
                ], 404);
            }

            // Return lists in JSON format
            return response()->json([
                'success' => true,
                'data' => $listes,
            ], 200);
        } catch (\Exception $e) {
            // Handle exceptions and return error message
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching lists.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function createListe(Request $request)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        try {
            // Get the authenticated user
            $user = $request->user();

            // Create the list with UUID
            $liste = Liste::create([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'] ?? null,
                'user_id' => $user->id,
                'uuid' => (string) Str::uuid(), // Generate and assign UUID
            ]);

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'List created successfully.',
                'data' => $liste,
            ], 201);
        } catch (\Exception $e) {
            // Handle exceptions and return error response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the list.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function deleteliste(Request $request, $id)
    {
        $user=$request->user();
        try {
            // Retrieve the list by ID and ensure it belongs to the authenticated user
            $liste = Liste::where('id', $id)
                ->where('user_id', $user->id)
                ->first();
    
            // Check if the list was found
            if (!$liste) {
                return response()->json([
                    'success' => false,
                    'message' => 'List not found or unauthorized.',
                ], 404);
            }
    
            // Delete the list
            $liste->delete();
    
            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'List deleted successfully.',
            ], 200);
    
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the list.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    

}
