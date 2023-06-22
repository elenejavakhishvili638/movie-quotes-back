<?php

namespace App\Http\Controllers;

use App\Events\NotificationReceived;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{

    public function index()
    {
        $notifications = Notification::with('actionUser')->where('user_id', Auth::id())->latest()->get();
        return NotificationResource::collection($notifications);
    }

    public function store(StoreNotificationRequest $request, $id)
    {

        $attributes = $request->validated();

        $attributes['user_id'] = $id;

        $attributes['action_user_id'] = Auth::id();
        $notification = null;

        if ($attributes['user_id'] != $attributes['action_user_id']) {

            $notification = Notification::create($attributes);

            $notificationResource = new NotificationResource($notification->load('actionUser'));
            event(new NotificationReceived($notificationResource));
        }

        if ($notification !== null) {
            return response()->json($notification, 201);
        } else {
            return response()->json(['message' => 'No notification was created.'], 200);
        }
    }

    public function markAsRead($id)
    {
        $notification = Notification::find($id);
        $notification->update(['read_at' => now()]);
        return response()->json($notification);
    }

    public function markAllAsRead()
    {
        Notification::where('action_user_id', Auth::id())->whereNull('read_at')->update(['read_at' => now()]);
        return response()->json('All notifications marked as read.');
    }
}
