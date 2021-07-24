<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\Profile as ProfileResource;
use App\Models\Notification;

class ProfileController extends BaseController
{


    public function index()
    {
        $user = Auth::user();
        $id = Auth::id();
        if ($user->profile == null) {
            $profile = Profile::create([
                'first_name' => 'Yuor First Name',
                'second_name' => 'Yuor second Name',
                'user_id' => $id,
                'address' => 'Undefined',
                'phone' => '+09',
                'gender' => 'female',
                'image' => 'profile/image/160Hf.png',
                'date_of_birth' => '1990/4/4'
            ]);
            return $this->sendResponse($profile,'has created successfully');
        }
        return $this->sendResponse($user->profile,'has created successfully');
    }

    public function update(Request $request, Profile $profile)
    {
        $input = $request->all();

        $notification = Notification::where('from_user_id',Auth::id())->first();

        $validator = Validator::make($input,[
            'first_name' => 'required',
            'second_name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            // 'image' => 'required|image',
            'bio' => 'required',
            'date_of_birth' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation error' , $validator->errors());
        }

        if ( $profile->user_id != Auth::id()) {
            return $this->sendError('you dont have rights' , $validator->errors());
        }

        if ($request->image != null) {

            $photo = $request->image;
            $newPhoto = time().$photo->getClientOriginalName();
            $photo->move('profile/image',$newPhoto);

            $input['image']='profile/image/'.$newPhoto;
            $profile->image=$input['image'];
            if ($notification!=null) {
                $notification->image=$input['image'];
            }

            }

        $profile->first_name = $input['first_name'];
        $profile->second_name = $input['second_name'];
        $profile->address = $input['address'];
        $profile->phone = $input['phone'];
        $profile->gender = $input['gender'];
        $profile->bio = $input['bio'];
        $profile->date_of_birth = $input['date_of_birth'];

        $profile->save();

        if ($notification!=null) {
        $notification->first_name = $input['first_name'];
        $notification->second_name = $input['second_name'];
        $notification->save();
        }

        return $this->sendResponse(new ProfileResource($profile), 'Profile updated Successfully!' );

    }


    public function show($id)
    {
        $profile = Profile::where('user_id',$id)->first();
        $message = [];
        if ($profile == null) {
            return $this->sendError('there is no profile to that user',$message);
        }
        return $this->sendResponse(new ProfileResource($profile),'the profile retrived successfully');
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
