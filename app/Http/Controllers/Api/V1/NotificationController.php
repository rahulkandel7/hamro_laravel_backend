<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationRequest;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = Notification::all();
        return response()->json([
            'data' => $notifications,
            'message' => 'success',
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NotificationRequest $request)
    {
        $notification = Notification::create($request->all());
            //change notification for mobile
        $key = "AAAAv9nDc7I:APA91bGiiXJaNi88v25L5_EOjn3juz1YL1FpTbqmRO-mUlsvXT2BXtwz7nkOo0dFJCqJAkmHFngmj3L4jAtCmXpd-yP_90Sb3g2zdYOfFV9KJW-R9XDHilHq2IEKhUYIZFokk6Ijvg07";

        $mydata = [
           'topic' => 'all',
           'notification' => [
               'body' => $notification->description,
               'title' => $notification->title,
           ],

        ];

        $jsondata = json_encode($mydata);

        $header = [
           'Authorization: key='.$key,
           'Content-Type: application/json',
        ];

        $ch = curl_init();
     
       curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $jsondata);

       curl_exec($ch);
        
        return response()->json([
            'data' => $notification,
            'message' => 'success',
        ], 200);
    }

    public function resend($id)
    {
        $notification = Notification::find($id);
            //change notification for mobile
        $key = "AAAAv9nDc7I:APA91bGiiXJaNi88v25L5_EOjn3juz1YL1FpTbqmRO-mUlsvXT2BXtwz7nkOo0dFJCqJAkmHFngmj3L4jAtCmXpd-yP_90Sb3g2zdYOfFV9KJW-R9XDHilHq2IEKhUYIZFokk6Ijvg07";

        $mydata = [
           'topic' => 'all',
           'notification' => [
               'body' => $notification->description,
               'title' => $notification->title,
           ],

        ];

        $jsondata = json_encode($mydata);

        $header = [
           'Authorization: key='.$key,
           'Content-Type: application/json',
        ];

        $ch = curl_init();
     
       curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $jsondata);

       curl_exec($ch);
        
        return response()->json([
            'data' => $notification,
            'message' => 'success',
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        return response()->json([
            'data' => $notification,
            'message' => 'success',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(NotificationRequest $request, Notification $notification)
    {
        $notification->update($request->all());
        return response()->json([
            'data' => $notification,
            'message' => 'success',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();
        return response()->json([
            'data' => $notification,
            'message' => 'success',
        ], 200);
    }
}
