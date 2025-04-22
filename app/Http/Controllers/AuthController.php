<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6'],
            'noTelp' => ['required', 'string', 'min:11', 'max:13', 'regex:/^[0-9]+$/'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Hash password
        $data['password'] = bcrypt($data['password']);

        // Simpan gambar jika ada
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $data['profile_image'] = $imagePath; // Simpan path gambar ke database
        }

        // Buat user
        $user = User::create($data);

        return response()->json([
            'user' => $user,
            'message' => 'Registrasi sukses'
        ], 201);
    }

    public function login(Request $request)
    {
        // Validasi input
        Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s\-\'\.]+$/', // Hanya huruf, spasi, tanda hubung, petik, dan titik
            ],
            'password' => 'required|min:6',
        ])->validate();

        // Ambil input
        $name = $request->input('name');
        $password = $request->input('password');

        // Verifikasi kredensial menggunakan web guard
        if (!Auth::guard('web')->attempt(['name' => $name, 'password' => $password])) {
            return response()->json([
                'errors' => 'Invalid Credentials',
            ], 400);
        }

        // Ambil user dan buat token
        $user = User::where('name', $name)->first();

        // Process profile image URL
        $profileImage = $user->profile_image;
        if ($profileImage) {
            // If it's not already a complete URL, generate the full URL
            if (!filter_var($profileImage, FILTER_VALIDATE_URL)) {
                $profileImage = asset('storage/' . $profileImage);
            }
        } else {
            $profileImage = ''; // Empty string if no image
        }

        // Buat data user dengan role
        $userData = $user->toArray();
        $userData['profile_image'] = $profileImage;

        $token = $user->createToken('auth_token')->plainTextToken;

        // Return user and token with role info
        return response()->json([
            'user' => $userData,
            'role' => $user->role, // Sertakan role dalam respons
            'token' => $token,
            'message' => 'Login berhasil',
        ], 200);
    }



    public function index()
    {
        $user = User::all();
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditemukan',
            'data' => $user
        ]);
    }

    public function show(string $id)
    {
        $user = User::findorFail($id);
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditemukan',
            'data' => $user
        ]);
    }
}
