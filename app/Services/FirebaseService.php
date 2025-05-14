<?php

namespace App\Services;

use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;

class FirebaseService
{
    public static function sendNotification($token, $title, $body, $data = [])
    {
        $messaging = Firebase::messaging();
        
        $notification = Notification::create($title, $body);
        
        $message = CloudMessage::withTarget('fcm_token', $token)
            ->withNotification($notification)
            ->withData($data);
            
        try {
            $messaging->send($message);
            return true;
        } catch (\Exception $e) {
            \Log::error('FCM Error: '.$e->getMessage());
            return false;
        }
    }
}