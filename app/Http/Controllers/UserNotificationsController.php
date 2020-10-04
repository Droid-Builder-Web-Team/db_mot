<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserNotificationsController extends Controller
{

    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('verified');
    }

    public function index()
    {
        $notifications = auth()->user()->notifications;

        $notifications->markAsRead();

        return view('notifications.show', [
          'notifications' => $notifications
        ]);
    }

    public function read($id)
    {
        $notification = auth()->user()->notifications()->find($id);
        if($notification) {
          $notification->markAsRead();
        }

        return redirect($notification->data['link']);
    }

}
