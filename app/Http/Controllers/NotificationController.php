<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\Notification as ResourcesNotification;

class NotificationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        $errorMessage = [];
        if (Auth::id()!=$id) {
            return $this->sendError('you do not have right',$errorMessage);
        }
        $notification = Notification::where('user_id',$id)->get();
        if (!Notification::where('user_id',$id)->first()) {
            return  $this->sendError('there is notification ',$errorMessage);
        }
        return $this->sendResponse(ResourcesNotification::collection($notification),'notification retrieved successfully!');
    }


    public function update(Request $request, Notification $notification)
    {
        $errorMessage = [];
        $this->validate($request,[
            'seen'=>['required'],
        ]);
        if (Auth::id()!=$notification->user_id) {
            return $this->sendError('you do not have right',$errorMessage);
        }
        $notification->seen=$request->seen;
        $notification->save();
        return $this->sendResponse(new ResourcesNotification($notification),'The notification has marked as seen');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        //
    }
}
