<?php
namespace App\Http\Controllers;

use App\Models\DeviceToken;
use App\Models\User;
use Illuminate\Http\Request;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class NotificationController extends Controller
{
    public function storeDeviceToken(Request $request)
    {
        $request->validate([
            'device_token' => 'required|string',
            'user_id'      => 'required|numeric|exists:users,id',

        ]);
        // Store token
        $deviceToken               = new DeviceToken();
        $deviceToken->device_token = $request->device_token;
        $deviceToken->user_id      = $request->user_id;
        $deviceToken->save();

        return response()->json(['success' => 'Device token stored successfully!']);
    }

    // to push notification to specific user
    public function sendNotification(Request $request)
    {
        $request->validate([
            'device_token' => 'required|string',
            'title'        => 'required|string',
            'body'         => 'required|string',
        ]);

        $user = User::whereHas('deviceTokens', function ($query) use ($request) {
            $query->where('device_token', $request->device_token);
        })->first();

        if (! $user) {
            return response()->json(['message' => 'User not found!'], 404);
        }

        // send notification to user device using firebase
        $messaging = app('firebase.messaging');
        $message   = CloudMessage::withTarget('token', $user->deviceTokens->first()->device_token)
            ->withNotification(Notification::create($request->title, $request->body));

        $messaging->send($message);

        return response()->json(['message' => 'Notification sent successfully!']);
    }

    // to push notification to all users
    public function sendNotificationToAllUsers(Request $request)
    {
        $title = "Important App Update";
        $body  = "We've added exciting new features! Check out the latest version now.";

        // Get all device tokens
        $deviceTokens = DeviceToken::all();

        if ($deviceTokens->isEmpty()) {
            return response()->json(['message' => 'No device tokens found!'], 404);
        }

        $messaging    = app('firebase.messaging');
        $successCount = 0;
        $failureCount = 0;

        // Send notification to each device token
        foreach ($deviceTokens as $deviceToken) {
            try {
                $message = CloudMessage::withTarget('token', $deviceToken->device_token)
                    ->withNotification(Notification::create($title, $body));

                $messaging->send($message);
                $successCount++;
            } catch (\Exception $e) {
                $failureCount++;

                // Log::error('Failed to send notification: ' . $e->getMessage());
            }
        }

        return response()->json([
            'message' => 'Notification sent completed',
            'success' => $successCount,
            'failure' => $failureCount,
        ]);
    }
}
