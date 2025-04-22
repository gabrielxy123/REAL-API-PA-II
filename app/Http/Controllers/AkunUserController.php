<?php

namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Storage;
    use App\Models\User;
    use Illuminate\Support\Facades\URL;


class   AkunUserController extends Controller
{
    public function getUserProfile(Request $request)
    {
        // Ambil data pengguna yang sedang login
        $user = Auth::user();

        if ($user) {
            // Check if profile_image is a URL or a local file path
            $profileImage = $user->profile_image;
            if ($profileImage) {
                // If it's already a complete URL, use it as-is
                if (!filter_var($profileImage, FILTER_VALIDATE_URL)) {
                    // If it's a local file path, generate the full URL
                    $profileImage = asset('storage/' . $profileImage);
                }
            } else {
                $profileImage = ''; // Empty string if no image
            }

            return response()->json([
                'status' => 'success',
                'data' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'noTelp' => $user->noTelp,
                    'profile_image' => $profileImage,
                ],
            ],200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not authenticated',
            ], 401);
        }
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not authenticated',
            ], 401);
        }

        try {
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'email' => 'required|email|unique:users,email,' . $user->id,
                'noTelp' => 'required|string|min:11|max:13|regex:/^[0-9]+$/',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Log incoming data
            \Illuminate\Support\Facades\Log::info('Update Profile Request', [
                'user_id' => $user->id,
                'email' => $request->email,
                'noTelp' => $request->noTelp
            ]);

            $user->email = $request->email;
            $user->noTelp = $request->noTelp;
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Profile updated successfully',
                'data' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'noTelp' => $user->noTelp,
                    'profile_image' => $user->profile_image ? asset('storage/' . $user->profile_image) : '',
                ],
            ], 200);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error updating profile', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update profile: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function updateProfileImage(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not authenticated',
            ], 401);
        }

        try {
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'profileImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Log incoming data
            \Illuminate\Support\Facades\Log::info('Update Profile Image Request', [
                'user_id' => $user->id,
                'has_file' => $request->hasFile('profileImage')
            ]);

            if ($request->hasFile('profileImage')) {
                // Delete old image if exists
                if ($user->profile_image) {
                    Storage::disk('public')->delete($user->profile_image);
                }

                // Store new image
                $imagePath = $request->file('profileImage')->store('profile_images', 'public');
                $user->profile_image = $imagePath;
                $user->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Profile image updated successfully',
                    'data' => [
                        'profile_image' => asset('storage/' . $imagePath),
                    ],
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'No image file provided',
            ], 400);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error updating profile image', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update profile image: ' . $e->getMessage(),
            ], 500);
        }
    }

    // New method to update profile image from URL
    public function updateProfileImageUrl(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not authenticated',
            ], 401);
        }

        try {
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'profileImageUrl' => 'required|url',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Log incoming data
            \Illuminate\Support\Facades\Log::info('Update Profile Image URL Request', [
                'user_id' => $user->id,
                'image_url' => $request->profileImageUrl
            ]);

            // Delete old image if it's a local file
            if ($user->profile_image && !filter_var($user->profile_image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($user->profile_image);
            }

            // Save the external URL directly
            $user->profile_image = $request->profileImageUrl;
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Profile image updated successfully',
                'data' => [
                    'profile_image' => $user->profile_image,
                ],
            ], 200);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error updating profile image URL', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update profile image URL: ' . $e->getMessage(),
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

