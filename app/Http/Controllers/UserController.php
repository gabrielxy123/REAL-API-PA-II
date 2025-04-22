<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;


class UserController extends Controller
{
    public function uploadProfileImage(Request $request)
    {
        try {
            if (!$request->hasFile('profile_image')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No image file uploaded'
                ], 400);
            }

            $image = $request->file('profile_image');
            
            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!in_array($image->getMimeType(), $allowedTypes)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid file type. Only JPG, JPEG, and PNG are allowed.'
                ], 400);
            }

            // Validate file size (max 5MB)
            if ($image->getSize() > 5 * 1024 * 1024) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'File size too large. Maximum size is 5MB.'
                ], 400);
            }

            // Generate unique filename
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            
            // Store file in public storage
            $path = $image->storeAs('public/profile_images', $filename);
            
            if (!$path) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to store image'
                ], 500);
            }

            // Get the authenticated user
            $user = $request->user();
            
            // Delete old profile image if exists
            if ($user->profile_image) {
                $oldPath = str_replace(url('/storage/'), 'public/', $user->profile_image);
                if (Storage::exists($oldPath)) {
                    Storage::delete($oldPath);
                }
            }

            // Update user's profile image URL
            $user->profile_image = url('/storage/profile_images/' . $filename);
            $user->save();

            // Debug information
            \Log::info('Image uploaded successfully', [
                'path' => $path,
                'url' => $user->profile_image,
                'exists' => Storage::exists($path)
            ]);

            return response()->json([
                'status' => 'success',
                'image_url' => $user->profile_image,
                'message' => 'Profile image updated successfully'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error uploading profile image: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function saveImage($image, $path = 'public')
    {
        if($image){
            return null;
        }

        $filename = time().'.png';
        //save image
        Storage::disk($path)->put($filename, base64_decode($image));

        //return URL
        return URL::to('/').'/storage/'.$path.'/'.$filename;
    }
} 