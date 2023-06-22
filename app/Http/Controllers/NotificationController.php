<?php

namespace App\Http\Controllers;

use App\Events\NotificationReceived;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $notification = Notification::create($attributes);

        $notificationResource = new NotificationResource($notification->load('actionUser'));
        event(new NotificationReceived($notificationResource));

        return response()->json($notification, 201);
    }
}
