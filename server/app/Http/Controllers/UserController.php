<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        // Validate the request input
        $request->validate([
            'name' => 'required|string|max:255',
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed', // 'confirmed' checks against 'password_confirmation'
        ]);

        // Check if the current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Invalid current password'], 401);
        }

        // Update user information
        $user->name = $request->name;

        // Update the password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Save the updated user data
        $user->save();

        // Return a success response
        return response()->json([
            'message' => 'Profile updated successfully.',
            'user' => $user
        ], 200);
    }

    public function updateUserImage(Request $request)
    {
        $user = $request->user();

        // Validate that an image file is provided
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max size
        ]);

        // Check if the user already has an image
        if ($user->image) {
            // Delete the existing image from storage
            Storage::disk('public')->delete($user->image);
        }

        // Store the new image in the 'public/user_images' directory
        $path = $request->file('image')->store('user_images', 'public'); // Specify 'public' disk

        // Update the user's image path in the database
        $user->image = $path;
        $user->save();

        // Generate a public URL for the image
        $imageUrl = Storage::url($path);

        // Return a success response with the new image path
        return response()->json([
            'message' => 'User image updated successfully.',
            'image_url' => $imageUrl, // Accessible URL
        ], 200);
    }
    public function deleteUserImage(Request $request)
    {
        $user = $request->user();

        // Check if the user has an existing image
        if ($user->image) {
            // Ensure the image is in the 'public' disk
            $imagePath = $user->image; // 'user_images/P2UYVvHy4fStakHfEWR1MtWKYxZVjeJKMRfzOo4w.jpg'

            // Check if the file exists in the public disk before attempting to delete it
            if (Storage::disk('public')->exists($imagePath)) {
                // Delete the image file from the 'public' disk
                Storage::disk('public')->delete($imagePath);

                // Set the user's image path to null in the database
                $user->image = null;
                $user->save();

                // Return a success response
                return response()->json([
                    'message' => 'User image deleted successfully.'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Image not found.'
                ], 404);
            }
        } else {
            // Return a message if there was no image to delete
            return response()->json([
                'message' => 'No image to delete.'
            ], 404);
        }
    }
}
