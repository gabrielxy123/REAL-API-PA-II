<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\Toko;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class TokoController extends Controller
{
    public function index()
    {
        $tokos = Toko::all();
        return response()->json([
            'message' => 'Data toko berhasil diambil',
            'data' => $tokos
        ], 200);
    }

    public function getBuktiBayar($id)
    {
        $toko = Toko::findOrFail($id);

        if (!$toko->buktiBayar) {
            return response()->json([
                'messgae' => 'Bukti Bayar tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'buktiBayar_url' => $toko->buktiBayar
        ]);
    }

    public function indexUser()
    {
        $tokos = Toko::where('status', 'Diterima')->get();
        return response()->json([
            'message' => 'Data toko berhasil diambil',
            'data' => $tokos
        ], 200);
    }

    public function approve($id)
    {
        try {
            $toko = Toko::findOrFail($id);

            // Validasi status
            if ($toko->status === 'Diterima') {
                return response()->json([
                    'success' => false,
                    'message' => 'Toko sudah dalam status Diterima'
                ], 400);
            }

            // Update hanya status
            $toko->update([
                'status' => 'Diterima'
            ]);

            // Ambil user yang mendaftar toko
            $user = $toko->user; // Pastikan relasi 'user' sudah didefinisikan di model Toko
            $fcmToken = $user->fcm_token;

            // Kirim notifikasi jika FCM token tersedia
            if ($fcmToken) {
                $this->sendNotification(
                    $fcmToken,
                    'Toko Disetujui',
                    'Selamat! Toko Anda telah disetujui oleh admin.'
                );
            }

            return response()->json([
                'success' => true,
                'message' => 'Toko berhasil disetujui',
                'data' => $toko
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyetujui toko',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Reject toko
    public function reject($id)
    {
        try {
            $toko = Toko::findOrFail($id);

            if ($toko->status === 'Ditolak') {
                return response()->json([
                    'success' => false,
                    'message' => 'Toko sudah dalam status Ditolak'
                ], 400);
            }

            // Update status saja tanpa menyimpan alasan
            $toko->update([
                'status' => 'Ditolak'
            ]);

            // Ambil user yang mendaftar toko
            $user = $toko->user; // Pastikan relasi 'user' sudah didefinisikan di model Toko
            $fcmToken = $user->fcm_token;

            // Kirim notifikasi jika FCM token tersedia
            if ($fcmToken) {
                $this->sendNotification(
                    $fcmToken,
                    'Toko Ditolak',
                    'Maaf, Permintaan Pendaftaran Toko Anda ditolak oleh admin.'
                );
            }

            return response()->json([
                'success' => true,
                'message' => 'Toko berhasil ditolak'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menolak toko',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'noTelp' => 'required|string|regex:/^[0-9]{10,15}$/',
            'email' => 'required|email|unique:tokos,email|max:255',
            'deskripsi' => 'nullable|string|max:500',
            'jalan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kabupaten' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'waktuBuka' => 'required|date_format:H:i:s',
            'waktuTutup' => 'required|date_format:H:i:s|after:waktuBuka',
        ]);

        $userId = Auth::id();

        if (Toko::where('userID', $userId)->exists()) {
            return response()->json([
                'message' => 'User sudah memiliki toko'
            ], 422);
        }

        // Simpan data toko
        $toko = Toko::create([
            'userID' => $userId,
            'nama' => $validated['nama'],
            'noTelp' => $validated['noTelp'],
            'email' => $validated['email'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'jalan' => $validated['jalan'],
            'kecamatan' => $validated['kecamatan'],
            'kabupaten' => $validated['kabupaten'],
            'provinsi' => $validated['provinsi'],
            'waktuBuka' => $validated['waktuBuka'],
            'waktuTutup' => $validated['waktuTutup'],
        ]);

        return response()->json([
            'message' => 'Toko berhasil dibuat',
            'data' => $toko
        ], 201);
    }

    public function sendNotification($token, $title, $body, $data = [])
    {
        try {
            $messaging = app('firebase.messaging');

            // Configure high priority for Android
            $androidConfig = [
                'priority' => 'high',
                'ttl' => '60s',
                'notification' => [
                    'channel_id' => 'high_importance_channel',
                ]
            ];

            // Configure high priority for iOS (APNS)
            $apnsConfig = [
                'headers' => [
                    'apns-priority' => '10',
                    'apns-push-type' => 'alert'
                ],
                'payload' => [
                    'aps' => [
                        'content-available' => 1,
                    ],
                ],
            ];

            // Create the message with high priority configuration
            $message = CloudMessage::withTarget('token', $token)
                ->withNotification(Notification::create($title, $body))
                ->withData($data)
                ->withAndroidConfig($androidConfig)
                ->withApnsConfig($apnsConfig);

            $response = $messaging->send($message);

            // Also save to database for history
            // Find user by FCM token
            $user = User::where('fcm_token', $token)->first();

            if ($user) {
                Notifikasi::create([
                    'user_id' => $user->id,
                    'title' => $title,
                    'body' => $body,
                    'data' => $data,
                    'is_read' => false
                ]);
            }

            \Log::info('FCM Success:', [
                'token' => $token,
                'time_sent' => now()->toDateTimeString(),
                'message_id' => $response,
            ]);

            return true;
        } catch (\Exception $e) {
            \Log::error('FCM Error:', [
                'token' => $token,
                'error' => $e->getMessage(),
                'time' => now()->toDateTimeString(),
            ]);
            return false;
        }
    }

    public function uploadBuktiPembayaran(Request $request)
    {
        try {
            // Validasi apakah file diunggah
            if (!$request->hasFile('buktiBayar')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No image file uploaded'
                ], 400);
            }

            $image = $request->file('buktiBayar');

            // Validasi tipe file
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!in_array($image->getMimeType(), $allowedTypes)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid file type. Only JPG, JPEG, and PNG are allowed.'
                ], 400);
            }

            // Validasi ukuran file (maksimum 5MB)
            if ($image->getSize() > 5 * 1024 * 1024) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'File size too large. Maximum size is 5MB.'
                ], 400);
            }

            // Generate nama file unik
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

            // Simpan file ke storage publik
            $path = $image->storeAs('public/bukti_pembayaran', $filename);

            if (!$path) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to store image'
                ], 500);
            }

            // Dapatkan toko milik user yang sedang login
            $userId = Auth::id();
            $toko = Toko::where('userID', $userId)->first();

            if (!$toko) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Toko tidak ditemukan'
                ], 404);
            }

            // Hapus bukti bayar lama jika ada
            if ($toko->buktiBayar) {
                $oldPath = str_replace(url('/storage/'), 'public/', $toko->buktiBayar);
                if (Storage::exists($oldPath)) {
                    Storage::delete($oldPath);
                }
            }

            // Update URL bukti bayar di database
            $toko->buktiBayar = url('/storage/bukti_pembayaran/' . $filename);
            $toko->status = 'Menunggu';
            $toko->save();

            // Ambil FCM token dari admin
            $adminTokens = User::where('role', 'admin')
                ->whereNotNull('fcm_token')
                ->pluck('fcm_token')
                ->toArray();

            // In uploadBuktiPembayaran method
            if (!empty($adminTokens)) {
                $notificationTitle = 'Pendaftaran Toko Baru';
                $notificationBody = 'Toko baru telah terdaftar dengan nama: ' . $toko->nama;

                // Additional data that might be useful for the app
                $data = [
                    'event_type' => 'new_store_registration',
                    'store_id' => $toko->id,
                    'store_name' => $toko->nama,
                    'timestamp' => now()->timestamp
                ];

                // Send to each admin token
                foreach ($adminTokens as $token) {
                    $this->sendNotification(
                        $token,
                        $notificationTitle,
                        $notificationBody,
                        $data
                    );
                }
            }
            return response()->json([
                'status' => 'success',
                'image_url' => $toko->buktiBayar,
                'message' => 'Bukti pembayaran uploaded successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error uploading bukti pembayaran: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }


    public function saveBuktiPembayaran($image, $path = 'public')
    {
        if ($image) {
            return null;
        }

        $filename = time() . '.png';
        //save image
        Storage::disk($path)->put($filename, base64_decode($image));

        //return URL
        return URL::to('/') . '/storage/' . $path . '/' . $filename;
    }

    public function show(Toko $toko)
    {
        return response()->json([
            'message' => 'Detail toko berhasil diambil',
            'data' => $toko
        ], 200);
    }

    public function update(Request $request, Toko $toko)
    {
        $validated = $request->validate([
            'nama' => 'sometimes|required',
            'no_telp' => 'sometimes|required',
            'email' => 'sometimes|required|email|unique:tokos,email,' . $toko->id,
            'deskripsi' => 'nullable',
            'jalan' => 'sometimes|required',
            'kecamatan' => 'sometimes|required',
            'kabupaten' => 'sometimes|required',
            'provinsi' => 'sometimes|required',
            'waktu_buka' => 'sometimes|required',
            'waktu_tutup' => 'sometimes|required',
        ]);
        $toko->update($validated);
        return response()->json([
            'message' => 'Toko berhasil diperbarui',
            'data' => $toko
        ], 200);
    }

    public function destroy(Toko $toko)
    {
        $toko->delete();
        return response()->json([
            'message' => 'Toko berhasil dihapus',
            'data' => null
        ], 200);
    }
}
