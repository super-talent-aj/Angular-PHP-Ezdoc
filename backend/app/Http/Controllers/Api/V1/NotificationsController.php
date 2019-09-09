<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\User;

class NotificationsController extends Controller
{
    public function index(Request $request)
    {
        $data = Notification::all();
        
    	return $data;
    }

    public function getNotificationsByUser(Request $request, $id)
    {
    	$notifications = Notification::where(['user_id' => $id, 'read' => false])->get();

    	return $notifications;
    }

    public function readNotification(Request $request, $id)
    {
    	$notification = Notification::find($id);
    	$notification->read = true;

    	return ($notification->save())
    		? json()->success('Notification has been read.')
    		: json()->badRequestError('Failed to read notification.');
    }
}
